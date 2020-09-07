/*!
   ----------------------------
       Relative Design 1 
   ----------------------------
     Version - 1.0.0 | © 2016 Relative Design | Licensed under MIT 
      ~ getRelativeDesign.com  
	  ~ tutorial.getRelativeDesign.com 
      ~ https://github.com/Avimm5/Relative-Design/blob/master/LICENSE	  
 */
 
// this creates row 

//for sticky div

$ = document.querySelectorAll.bind(document);
  // how far is the green div from the top of the page?
  var initStickyTop = $(".stickdiv")[0].getBoundingClientRect().top + pageYOffset;
  // clone the green div
  var clone = $(".stickdiv")[0].cloneNode(true);
  // hide it first
  clone.style.display = "none";
  // add it to dom
  document.body.appendChild(clone);
    addEventListener("scroll",stick=function() {
      // if user scroll past the sticky div
      if (initStickyTop < pageYOffset) {
        // hide the green div but the div still take up the same space as before so scroll position is not changed
        $(".stickdiv")[0].style.opacity = "0";
        // make the clone sticky
        clone.classList.add('stick');
        // show the clone
        clone.style.opacity="1";
        clone.style.display = "block";
      } else {
        // make the clone not sticky anymore
        clone.classList.remove("stick");
        // hide it
        clone.style.display = "none";
        // show the green div
        $(".stickdiv")[0].style.opacity="1";
      };
    });
    // when resize, recalculate the position of the green div
    addEventListener("resize", function() {
      initStickyTop = $(".stickdiv")[0].getBoundingClientRect().top + pageYOffset;
      stick();
    });
	
   var r = document.getElementsByClassName('image');
    var targets = document.getElementsByClassName('msginname');
    var rgb = [];
    for (p = 0 ; p < r.length ; p++ ){
       rgb.push(getAverageRGB(r[p]));
    }
    rgb.forEach((el,i) => {
       targets[i].style.color = 'rgb('+el.r+','+el.g+','+el.b+')';
    })
    

function getAverageRGB(imgEl) {
    
    var blockSize = 5, // only visit every 5 pixels
        defaultRGB = {r:0,g:0,b:0}, // for non-supporting envs
        canvas = document.createElement('canvas'),
        context = canvas.getContext && canvas.getContext('2d'),
        data, width, height,
        i = -4,
        length,
        rgb = {r:0,g:0,b:0},
        count = 0;
        
    if (!context) {
        return defaultRGB;
    }
    
    height = canvas.height = imgEl.naturalHeight || imgEl.offsetHeight || imgEl.height;
    width = canvas.width = imgEl.naturalWidth || imgEl.offsetWidth || imgEl.width;
    
    context.drawImage(imgEl, 0, 0);
    
    try {
        data = context.getImageData(0, 0, width, height);
    } catch(e) {
        return defaultRGB;
    }
    
    length = data.data.length;
    
    while ( (i += blockSize * 4) < length ) {
        ++count;
        rgb.r += data.data[i];
        rgb.g += data.data[i+1];
        rgb.b += data.data[i+2];
    }
    
    // ~~ used to floor values
    rgb.r = ~~(rgb.r/count);
    rgb.g = ~~(rgb.g/count);
    rgb.b = ~~(rgb.b/count);
    
    return rgb;
    
}
