/*
 * timeout-dialog.js v1.0.1, 01-03-2012
 *
 * @author: Rodrigo Neri (@rigoneri)
 *
 * (The MIT License)
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */


/* String formatting, you might want to remove this if you already use it.
 * Example:
 *
 * var location = 'World';
 * alert('Hello {0}'.format(location));
 */
String.prototype.format = function() {
  var s = this,
      i = arguments.length;

  while (i--) {
    s = s.replace(new RegExp('\\{' + i + '\\}', 'gm'), arguments[i]);
  }
  return s;
};

!function($) {
  $.timeoutDialog = function(options, IndexEmployee) {

    var settings = {
        timeout: 15,
        countdown: 60,
        title : 'Your session is about to expire!',
        message : 'You will be out in {0} seconds.',
        question: '',
        keep_alive_button_text: 'Stay connected',
        sign_out_button_text: 'Logout',
        keep_alive_url: route('dialog_session',{'act':'YES'}),
        logout_redirect_url: route('dialog_session',{act:'NO',IndexEmployee: IndexEmployee})
    }

    $.extend(settings, options);

    var TimeoutDialog = {
      init: function () {
        this.setupDialogTimer();
      },

      setupDialogTimer: function() {
        var self = this;
        window.setTimeout(function() {
           self.setupDialog();
        }, (settings.timeout - settings.countdown) * 1000);
      },

      setupDialog: function() {
        var self = this;
        self.destroyDialog();

        var _ModalHeader = $('<h5 class="modal-title">'+settings.title+'</h5>');

        var _ModalBody = $('<div id="timeout-dialog">' +
                            '<p id="timeout-message" class="font-size-lg">' + settings.message.format('<span id="timeout-countdown" class="font-weight-bold">' + settings.countdown + '</span>') + '</p>' +
                        '</div>');

        BootstrapDialog.show({
            title: _ModalHeader,
            message: _ModalBody,
            closable: false,
            closeByBackdrop: false,
            closeByKeyboard: false,
            buttons: [{
                id: 'timeout-keep-signin-btn',
                label: settings.keep_alive_button_text,
                cssClass: 'btn-success',
                action: function(dialogItself) {
                    self.keepAlive();
                    dialogItself.close();
                }
            }, {
                id: 'timeout-sign-out-button',
                label: settings.sign_out_button_text,
                cssClass: 'btn-danger',
                action: function(dialogItself) {
                    self.signOut();
                    dialogItself.enableButtons(false);
                }
            }]
        });

        self.startCountdown();
      },

      destroyDialog: function() {
        if ($("#timeout-dialog").length) {
            $('#timeout-dialog').remove();
            $(".bootstrap-dialog-message").html('<p class="font-italic"><i class="icon-spinner9 spinner mr-1"></i>Loading....</p>')
        }
      },

      startCountdown: function() {
        var self = this,
            counter = settings.countdown;

        this.countdown = window.setInterval(function() {
          counter -= 1;
          $("#timeout-countdown").html(counter);

          if (counter <= 0) {
            window.clearInterval(self.countdown);
            setTimeout(function(){
                self.signOut();
             }, 2000);
          }

        }, 1000);
      },

      keepAlive: function() {
        var self = this;
        this.destroyDialog();
        window.clearInterval(this.countdown);

        $.get(settings.keep_alive_url, function(data) {
          if (data.url == "OK") {
              console.log(settings.keep_alive_button_text);
              getTimerForSession();
          }
          else {
            self.signOut();
          }
        });
      },

      signOut: function() {
        var self = this;
        this.destroyDialog();

        $.post(settings.logout_redirect_url, function(data){
            setTimeout(function(){
                self.redirectLogout(data.url);
            }, 2000);
        });
      },

      redirectLogout: function(url){
        var target = url;
        window.location = target;
      }
    };

    TimeoutDialog.init();
  };
}(window.jQuery);
