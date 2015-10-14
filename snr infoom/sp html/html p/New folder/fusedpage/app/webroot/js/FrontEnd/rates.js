// from arrays above
if (document.images) {
    var theImgs = new Array();
    for (var i=0; i<messages.length; i++) {
      theImgs[i] = new Image();
        theImgs[i].src = messages[i][0];
  }
}

// to layout image and text, 2-row table, image centered in top cell
// these go in var tip in doTooltip function
// startStr goes before image, midStr goes between image and text
var startStr = '<table width="' + tipWidth + '"><tr><td align="center" width="100%"><img src="';
var midStr = '" border="0" width="1" height="1"></td></tr><tr><td valign="top">';
var endStr = '</td></tr></table>';

////////////////////////////////////////////////////////////
//  initTip    - initialization for tooltip.
//        Global variables for tooltip. 
//        Set styles
//        Set up mousemove capture if tipFollowMouse set true.
////////////////////////////////////////////////////////////
var tooltip, tipcss;
function initTip() {
    if (nodyn) return;
    tooltip = (ie4)? document.all['tipDiv']: (ie5||ns5)? document.getElementById('tipDiv'): null;
    tipcss = tooltip.style;
    if (ie4||ie5||ns5) {    // ns4 would lose all this on rewrites
        tipcss.width = tipWidth+"px";
        tipcss.fontFamily = tipFontFamily;
        tipcss.fontSize = tipFontSize;
        tipcss.color = tipFontColor;
        tipcss.backgroundColor = tipBgColor;
        tipcss.borderColor = tipBorderColor;
        tipcss.borderWidth = tipBorderWidth+"px";
        tipcss.padding = tipPadding+"px";
        tipcss.borderStyle = tipBorderStyle;
    }
    if (tooltip&&tipFollowMouse) {
        document.onmousemove = trackMouse;
    }
}

window.onload = initTip;

/////////////////////////////////////////////////
//  doTooltip function
//            Assembles content for tooltip and writes 
//            it to tipDiv
/////////////////////////////////////////////////


var t1,t2;    // for setTimeouts
var tipOn = false;    // check if over tooltip link
function doTooltip(evt,num) {
    if (!tooltip) return;
    if (t1) clearTimeout(t1);    if (t2) clearTimeout(t2);
    tipOn = true;
    // set colors if included in messages array
    if (messages[num][2])    var curBgColor = messages[num][2];
    else curBgColor = tipBgColor;
    if (messages[num][3])    var curFontColor = messages[num][3];
    else curFontColor = tipFontColor;
    if (ie4||ie5||ns5) {
        var tip = startStr + messages[num][0] + midStr + '<span style="font-family:' + tipFontFamily + '; font-size:' + tipFontSize + '; color:' + curFontColor + ';">' + messages[num][1] + '</span>' + endStr;
        tipcss.backgroundColor = curBgColor;
         tooltip.innerHTML = tip;
    }
    if (!tipFollowMouse) positionTip(evt);
    else t1=setTimeout("tipcss.visibility='visible'",100);
}

var mouseX, mouseY;
function trackMouse(evt) {
    standardbody=(document.compatMode=="CSS1Compat")? document.documentElement : document.body //create reference to common "body" across doctypes
    mouseX = (ns5)? evt.pageX: window.event.clientX + standardbody.scrollLeft;
    mouseY = (ns5)? evt.pageY: window.event.clientY + standardbody.scrollTop;
    if (tipOn) positionTip(evt);
}

/////////////////////////////////////////////////////////////
//  positionTip function
//        If tipFollowMouse set false, so trackMouse function
//        not being used, get position of mouseover event.
//        Calculations use mouseover event position, 
//        offset amounts and tooltip width to position
//        tooltip within window.
/////////////////////////////////////////////////////////////
function positionTip(evt) {
    if (!tipFollowMouse) {
        mouseX = (ns5)? evt.pageX: window.event.clientX + standardbody.scrollLeft;
        mouseY = (ns5)? evt.pageY: window.event.clientY + standardbody.scrollTop;
    }
    // tooltip width and height
    var tpWd = (ie4||ie5)? tooltip.clientWidth: tooltip.offsetWidth;
    var tpHt = (ie4||ie5)? tooltip.clientHeight: tooltip.offsetHeight;
    // document area in view (subtract scrollbar width for ns)
    var winWd = (ns5)? window.innerWidth-20+window.pageXOffset: standardbody.clientWidth+standardbody.scrollLeft;
    var winHt = (ns5)? window.innerHeight-20+window.pageYOffset: standardbody.clientHeight+standardbody.scrollTop;
    // check mouse position against tip and window dimensions
    // and position the tooltip 
    if ((mouseX+offX+tpWd)>winWd) 
        tipcss.left = mouseX-(tpWd+offX)+"px";
    else tipcss.left = mouseX+offX+"px";
    if ((mouseY+offY+tpHt)>winHt) 
        tipcss.top = winHt-(tpHt+offY)+"px";
    else tipcss.top = mouseY+offY+"px";
    if (!tipFollowMouse) t1=setTimeout("tipcss.visibility='visible'",100);
}

function hideTip() {
    if (!tooltip) return;
    t2=setTimeout("tipcss.visibility='hidden'",100);
    tipOn = false;
}

document.write('<div id="tipDiv" style="position:absolute; visibility:hidden; z-index:100"></div>')







function ratestar(cls) {
		document.getElementById('sr').className='rating '+cls;
	    if(cls=='onestar') document.getElementById('raten').innerHTML='1';
		if(cls=='twostar') document.getElementById('raten').innerHTML='2';
		if(cls=='threestar') document.getElementById('raten').innerHTML='3';
		if(cls=='fourstar') document.getElementById('raten').innerHTML='4';
		if(cls=='fivestar') document.getElementById('raten').innerHTML='5';
	}