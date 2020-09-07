function foo() {



var xhttp = new XMLHttpRequest();
xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
          var xmlDoc = this.responseXML;
    
    var nodes = xmlDoc.getElementsByTagName('notifset'), 
    amountOfNodes = nodes.length ;
    
      postMessage(amountOfNodes);
    
          
          
    
    }
};
xhttp.open("GET", "../users/<?php echo $username; ?>/notification/notification.xml", false);

xhttp.setRequestHeader('Cache-Control', 'no-cache');
xhttp.send();


setTimeout(foo, 1000);

}

foo();













