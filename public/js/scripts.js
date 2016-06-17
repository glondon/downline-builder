/*
* Author: Greg London
* http://greglondon.info
*/

// Checks the browser and adds classes to the body to reflect it.
$(document).ready(function(){
    
    var userAgent = navigator.userAgent.toLowerCase();
    $.browser.chrome = /chrome/.test(navigator.userAgent.toLowerCase()); 
    
    // Is this a version of IE?
    if($.browser.msie){
        $('body').addClass('browserIE');
        
        // Add the version number
        $('body').addClass('browserIE' + $.browser.version.substring(0,1));
    }
    
    
    // Is this a version of Chrome?
    if($.browser.chrome){
    
        $('body').addClass('browserChrome');
        
        //Add the version number
        userAgent = userAgent.substring(userAgent.indexOf('chrome/') +7);
        userAgent = userAgent.substring(0,1);
        $('body').addClass('browserChrome' + userAgent);
        
        // If it is chrome then jQuery thinks it's safari so we have to tell it it isn't
        $.browser.safari = false;
    }
    
    // Is this a version of Safari?
    if($.browser.safari){
        $('body').addClass('browserSafari');
        
        // Add the version number
        userAgent = userAgent.substring(userAgent.indexOf('version/') +8);
        userAgent = userAgent.substring(0,1);
        $('body').addClass('browserSafari' + userAgent);
    }
    
    // Is this a version of Mozilla?
    if($.browser.mozilla){
        
        //Is it Firefox?
        if(navigator.userAgent.toLowerCase().indexOf('firefox') != -1){
            $('body').addClass('browserFirefox');
            
            // Add the version number
            userAgent = userAgent.substring(userAgent.indexOf('firefox/') +8);
            userAgent = userAgent.substring(0,1);
            $('body').addClass('browserFirefox' + userAgent);
        }
        // If not then it must be another Mozilla
        else{
            $('body').addClass('browserMozilla');
        }
    }
    
    // Is this a version of Opera?
    if($.browser.opera){
        $('body').addClass('browserOpera');
    }
    
    
});

// terms pop up

$(document).ready(function() {
	$('a[rel="external"]').click(function(){
  	window.open('http://paidtosignup/terms', 'terms', 'menubar=1,resizable=yes,scrollbars=yes,width=550,height=550,top=60,left=150');
  	return false;
	});
});

// navigation - still working on it

$(document).ready(function(){
	
	//Fix Errors - http://www.learningjquery.com/2009/01/quick-tip-prevent-animation-queue-buildup/
	
	//Remove outline from links
	$("a").click(function(){
		$(this).blur();
	});
	
	//When mouse rolls over
	$("li").mouseover(function(){
		$(this).stop().animate({height:'150px'},{queue:false, duration:600, easing: 'easeOutBounce'})
	});
	
	//When mouse is removed
	$("li").mouseout(function(){
		$(this).stop().animate({height:'50px'},{queue:false, duration:600, easing: 'easeOutBounce'})
	});
	
});

// For FAQ page

$(document).ready(function() {									
	$("a[name^='faq-']").each(function() {
		$(this).click(function() {
			if( $("#" + this.name).is(':hidden') ) {
				$("#" + this.name).toggle('slow');
			} else {
				$("#" + this.name).toggle('slow');
			}			
			return false;
		});
	});
});

// tooltip stuff

this.tooltip = function(){	
	/* CONFIG */		
		xOffset = 10;
		yOffset = 20;		
		// these 2 variable determine popup's distance from the cursor
		// you might want to adjust to get the right result		
	/* END CONFIG */		
	$("a.tooltip").hover(function(e){											  
		this.t = this.title;
		this.title = "";									  
		$("body").append("<p id='tooltip'>"+ this.t +"</p>");
		$("#tooltip")
			.css("top",(e.pageY - xOffset) + "px")
			.css("left",(e.pageX + yOffset) + "px")
			.fadeIn("slow");		
    },
	function(){
		this.title = this.t;		
		$("#tooltip").remove();
    });	
	$("a.tooltip").mousemove(function(e){
		$("#tooltip")
			.css("top",(e.pageY - xOffset) + "px")
			.css("left",(e.pageX + yOffset) + "px");
	});			
};



// starting the script on page load
$(document).ready(function(){
	tooltip();
});

/**
//form validation
// this code isn't working and screws up the entire file
$(document).ready(function(){
{
    $("input").blur(function()
    {
        var formElementId = $(this).parent().prev().find('label').attr('for');

        doValidation(formElementId);
    });
});
function doValidation(id)
{
    var url = 'http://paidtosignup/user/validateform';
    var data = {};
    $("input").each(function()
    {
        data[$(this).attr('name')] = $(this).val();
    });
    $.post(url,data,function(resp)
    {
        $("#"+id).parent().find('.errors').remove();
        $("#"+id).parent().append(getErrorHtml(resp[id], id));
    },'json');
}
function getErrorHtml(formErrors , id)
{
    var o = '<ul id="errors-'+id+'" class="errors">';
    for(errorKey in formErrors)
    {
        o += '<li>' + formErrors[errorKey] + '</li>';
    }
    o += '</ul>';
    return o;
}
**/

function terms(){window.open("http://paidtosignup/terms","mywindow","menubar=1,resizable=1,width=750,height=550,top=60,left=100");}