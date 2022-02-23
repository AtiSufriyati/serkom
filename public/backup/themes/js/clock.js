var dayarray = new Array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday")
var montharray = new Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December")

function getthedate() {
    var mydate = new Date()
    var year = mydate.getYear()

    if (year < 1000) {
        year += 1900
    }

    var day = mydate.getDay()
    var month = mydate.getMonth()
    var daym = mydate.getDate()

    if (daym < 10) {
        daym = "0" + daym
    }

    var hours = mydate.getHours()
    var minutes = mydate.getMinutes()
    var seconds = mydate.getSeconds()

    // var dn="AM"
    // if (hours>=12)
    // dn="PM"
    // if (hours>12){
    // 	hours=hours-12
    // }

    if (hours == 0){
        hours = 12
    }
    if (minutes <= 9){
        minutes = "0" + minutes
    }
    if (seconds <= 9){
        seconds = "0" + seconds
    }

    // SHOW NAVBAR
    var cdate = "<i class='icon-calendar2 mr-2 text-arjuna'></i>" + dayarray[day] + ", " + daym + " " + montharray[month] + " " + year + " " + hours + ":" + minutes + ":" + seconds + "</b>";

    // ATTANDANCE
    var attandenceDay = dayarray[day] + ", " + daym + " " + montharray[month] + " " + year;
    var attandanceTime = hours + ":" + minutes + ":" + seconds;

    if (document.all) {
        document.all.clock.innerHTML = cdate
    }
    else if (document.getElementById) {

        // SHOW NAVBAR
        document.getElementById("clock").innerHTML = cdate;

        // ATTANDANCE
        if (cekElement("#attandanceDay") && cekElement("#attandanceTime")){
            document.getElementById("attandanceDay").innerHTML = attandenceDay;
            document.getElementById("attandanceTime").innerHTML = attandanceTime;
        }
    }
    else {
        document.write(cdate)
    }
}

if (!document.all && !document.getElementById)
    getthedate()

function goforit() {
    document.getElementById("clock").innerHTML = '<span class="text-muted"><i class="icon-spinner2 spinner position-left mr-1"></i>Processing...</span>';
    if (document.all || document.getElementById){
        setInterval("getthedate()", 1000)
    }
}

function hideMainSidebar(param=null){
    if(param!='home' && param!='menu'){
        document.body.className = 'sidebar-xs';
    }

    if(param==''){
        document.body.className = 'sidebar-xs';
    }
}
