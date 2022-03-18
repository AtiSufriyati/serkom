<?php

namespace App\Helpers;

use App\Models\Chatify\Messages;
use App\Models\Chatify\Favorites;
use App\Models\Kenji\Employee\EmployeeContact;
use Pusher\Pusher;
use Illuminate\Support\Facades\Auth;
use Exception;
use DB;
use Carbon\Carbon;
use Session;

class ChatifyMessenger
{
    /**
     * Allowed extensions to upload attachment
     * [Images / Files]
     *
     * @var
     */
    public static $allowed_images = array('png','jpg','jpeg','gif');
    public static $allowed_files  = array('zip','rar','txt');

    /**
     * This method returns the allowed image extensions
     * to attach with the message.
     *
     * @return array
     */
    public function getAllowedImages(){
        return self::$allowed_images;
    }

    /**
     * This method returns the allowed file extensions
     * to attach with the message.
     *
     * @return array
     */
    public function getAllowedFiles(){
        return self::$allowed_files;
    }

    /**
     * Returns an array contains messenger's colors
     *
     * @return array
     */
    public function getMessengerColors(){
        return [
            '1' => '#2180f3',
            '2' => '#2196F3',
            '3' => '#00BCD4',
            '4' => '#3F51B5',
            '5' => '#673AB7',
            '6' => '#4CAF50',
            '7' => '#FFC107',
            '8' => '#FF9800',
            '9' => '#ff2522',
            '10' => '#9C27B0',
        ];
    }

    /**
     * Pusher connection
     */
    public function pusher()
    {
        return new Pusher(
            config('chatify.pusher.key'),
            config('chatify.pusher.secret'),
            config('chatify.pusher.app_id'),
            [
                'cluster' => config('chatify.pusher.options.cluster'),
                'useTLS' => config('chatify.pusher.options.useTLS')
            ]
        );
    }

    /**
     * Trigger an event using Pusher
     *
     * @param string $channel
     * @param string $event
     * @param array $data
     * @return void
     */
    public function push($channel, $event, $data)
    {
        return $this->pusher()->trigger($channel, $event, $data);
    }

    /**
     * Authintication for pusher
     *
     * @param string $channelName
     * @param string $socket_id
     * @param array $data
     * @return void
     */
    public function pusherAuth($channelName, $socket_id, $data = []){
        return $this->pusher()->socket_auth($channelName, $socket_id, $data);
    }

    /**
     * Fetch message by id and return the message card
     * view as a response.
     *
     * @param int $id
     * @return array
     */
    public function fetchMessage($id){
        $attachment = $attachment_type = $attachment_title = null;
        $msg = DB::table('dev_chatify.Messages')->where('IndexMessage',$id)->first();

        // If message has attachment
        if($msg->Attachment){
            // Get attachment and attachment title
            $att = explode(',',$msg->Attachment);
            $attachment       = $att[0];
            $attachment_title = $att[1];

            // determine the type of the attachment
            $ext = pathinfo($attachment, PATHINFO_EXTENSION);
            $attachment_type = in_array($ext,$this->getAllowedImages()) ? 'image' : 'file';
        }

        $date = Carbon::parse($msg->CreatedDate); // now date is a carbon instance
        $elapsed = $date->diffForHumans(Carbon::now());

        return [
            'id' => $msg->IndexMessage,
            'from_id' => $msg->CreatedByID,
            'to_id' => $msg->ToEmployeeID,
            'message' => $msg->Body,
            'attachment' => [$attachment, $attachment_title, $attachment_type],
            'time' => $elapsed,
            'fullTime' => $msg->CreatedDate,
            'viewType' => ($msg->CreatedByID == Session::get('USER_ID')) ? 'sender' : 'default',
            'seen' => $msg->Seen,
        ];
    }

    /**
     * Return a message card with the given data.
     *
     * @param array $data
     * @param string $viewType
     * @return void
     */
    public function messageCard($data, $viewType = null){
        $data['viewType'] = ($viewType) ? $viewType : $data['viewType'];
        return view('chat.layouts.messageCard',$data)->render();
    }

    /**
     * Default fetch messages query between a Sender and Receiver.
     *
     * @param int $user_id
     * @return Collection
     */
    public function fetchMessagesQuery($user_id){
        return DB::table('dev_chatify.Messages')->where('CreatedByID',Session::get('USER_ID'))->where('ToEmployeeID',$user_id)
                    ->orWhere('CreatedByID',$user_id)->where('ToEmployeeID',Session::get('USER_ID'));
    }

    /**
     * create a new message to database
     *
     * @param array $data
     * @return void
     */
    public function newMessage($data){
        DB::table('dev_chatify.Messages')->insert(
            array('IndexMessage' => $data['IndexMessage'], 
                    'Type' => $data['Type'], 
                    'ToEmployeeID' => $data['ToEmployeeID'], 
                    'ToEmployeeName' => $data['ToEmployeeName'],
                    'Body' => $data['Body'],
                    'Attachment' => $data['Attachment'], 
                    'CreatedDate' => $data['CreatedDate'],
                    'CreatedByID' => $data['CreatedByID'],
                    'CreatedByName' => $data['CreatedByName'],
                    'UpdatedDate' => $data['UpdatedDate'])
        );
    }

    /**
     * Make messages between the sender [Auth user] and
     * the receiver [User id] as seen.
     *
     * @param int $user_id
     * @return bool
     */
    public function makeSeen($user_id){
        DB::table('dev_chatify.Messages')->Where('CreatedByID',$user_id)
                ->where('ToEmployeeID',Session::get('USER_ID'))
                ->where('seen',0)
                ->update(['seen' => 1]);
        return 1;
    }

    /**
     * Get last message for a specific user
     *
     * @param int $user_id
     * @return Collection
     */
    public function getLastMessageQuery($user_id){
        return self::fetchMessagesQuery($user_id)->orderBy('CreatedDate','DESC')->first();
    }

    /**
     * Count Unseen messages
     *
     * @param int $user_id
     * @return Collection
     */
    public function countUnseenMessages($user_id){
        return DB::table('dev_chatify.Messages')->where('CreatedByID',$user_id)->where('ToEmployeeID',Session::get('USER_ID'))->where('Seen',0)->count();
    }

    /**
     * Get user list's item data [Contact Itme]
     * (e.g. User data, Last message, Unseen Counter...)
     *
     * @param int $messenger_id
     * @param Collection $user
     * @return void
     */
    public function getContactItem($messenger_id, $user){
        // get last message
        $lastMessage = self::getLastMessageQuery($user->EmployeeID);

        // Get Unseen messages counter
        $unseenCounter = self::countUnseenMessages($user->EmployeeID);

        return view('chat.layouts.listItem', [
            'get' => 'users',
            'user' => $user,
            'lastMessage' => $lastMessage,
            'unseenCounter' => $unseenCounter,
            'type'=>'user',
            'id' => $messenger_id,
        ])->render();
    }

    /**
     * Check if a user in the favorite list
     *
     * @param int $user_id
     * @return boolean
     */
    public function inFavorite($user_id){
        return DB::table('dev_chatify.Favorites')->where('CreatedByID', Session::get('USER_ID'))
                        ->where('FavoritesEmployeeID', $user_id)->count() > 0
                        ? true : false;

    }

    /**
     * Make user in favorite list
     *
     * @param int $user_id
     * @param int $star
     * @return boolean
     */
    public function makeInFavorite($user_id, $action){
        if ($action > 0) {
            $queryEmployee = EmployeeContact::select('EmployeeName')->where('EmployeeID', $user_id)->first();

            // Star
            $star = DB::table('dev_chatify.Favorites')->insert(
                array('IndexFavorites' => rand(9,99999999), 
                        'FavoritesEmployeeID' => $user_id,
                        'FavoritesEmployeeName' => $queryEmployee->EmployeeName,
                        'CreatedDate' => Carbon::now(),
                        'CreatedByID' => Session::get('USER_ID'),
                        'CreatedByName' => Session::get('USER_NAME'),
                        'UpdatedDate' => Carbon::now())
            );
            return $star ? true : false;
        }else{
            // UnStar
            $star = DB::table('dev_chatify.Favorites')->where('CreatedByID',Session::get('USER_ID'))->where('FavoritesEmployeeID',$user_id)->delete();
            return $star ? true : false;
        }
    }

    /**
     * Get shared photos of the conversation
     *
     * @param int $user_id
     * @return array
     */
    public function getSharedPhotos($user_id){
        $images = array(); // Default
        // Get messages
        $msgs = $this->fetchMessagesQuery($user_id)->orderBy('CreatedDate','DESC');
        if($msgs->count() > 0){
            foreach ($msgs->get() as $msg) {
                // If message has attachment
                if($msg->Attachment){
                    $attachment = explode(',',$msg->Attachment)[0]; // Attachment
                    // determine the type of the attachment
                    in_array(pathinfo($attachment, PATHINFO_EXTENSION), $this->getAllowedImages())
                    ? array_push($images, $attachment) : '';
                }
            }
        }
        return $images;

    }

    /**
     * Delete Conversation
     *
     * @param int $user_id
     * @return boolean
     */
    public function deleteConversation($user_id){
        try {
            foreach ($this->fetchMessagesQuery($user_id)->get() as $msg) {
                // delete from database
                $msg->delete();
                // delete file attached if exist
                if ($msg->attachment) {
                    $path = storage_path('app/public/'.config('chatify.attachments.folder').'/'.explode(',', $msg->attachment)[0]);
                    if(file_exists($path)){
                        @unlink($path);
                    }
                }
            }
            return 1;
        }catch(Exception $e) {
            return 0;
        }
    }

}
