addEvent(window, 'load', init, false);

function init() {
	
	var formInputs = document.getElementsByTagName('input');
    var textareas = document.getElementsByTagName('textarea');
    
	for (var i = 0; i < formInputs.length; i++) {
    
	    var theInput = formInputs[i];
        
        if (theInput.type == 'text' || theInput.type == 'password') {
			
            addEvent(theInput, 'focus', clearDefaultText, false);
            addEvent(theInput, 'blur', replaceDefaultText, false);
			
	    }
    
	}
	
	for (var i = 0; i < textareas.length; i++) {
    
	    var theInput = textareas[i];
		
		addEvent(theInput, 'focus', clearDefaultText, false);
		addEvent(theInput, 'blur', replaceDefaultText, false);
		
	}
	
}

function clearDefaultText(e) {
	
    var target = window.event ? window.event.srcElement : e ? e.target : null;
    
	if (!target) return;
	
    if (target.value == target.defaultValue) {
		
        target.value = '';
        target.style.color = '#000';
    
	} else if (target.value != target.defaultValue )
		/* the following protects saved passwords from staying gray. for some reason my firefox is returning
		   the color to be empty at first, so I set all styles to gray to begin with, save for the email
		   field.  kind of a haphazard way to implement the placeholder feature, eh? */
		target.style.color = "#000";
		
}

function replaceDefaultText(e) {
    
	var target = window.event ? window.event.srcElement : e ? e.target : null;
    
	if (!target) return;
    
    if (target.value == '' && target.defaultValue) {
        
		target.value = target.defaultValue;
        target.style.color = '#AAA';
		
    }
	
}

/* 
 * Cross-browser event handling, by Scott Andrew
 */
function addEvent(element, eventType, lamdaFunction, useCapture) {
    if (element.addEventListener) {
        element.addEventListener(eventType, lamdaFunction, useCapture);
        return true;
    } else if (element.attachEvent) {
        var r = element.attachEvent('on' + eventType, lamdaFunction);
        return r;
    } else {
        return false;
    }
}