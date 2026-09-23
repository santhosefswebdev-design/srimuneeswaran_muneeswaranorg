var visitDate=new Date();
var visitTime=String(Math.floor(visitDate.getTime()/1000));
var visitCode=visitTime.concat(String(Math.floor(Math.random()*10+1)-1)).concat(String(Math.floor(Math.random()*10+1)-1)).concat(String(Math.floor(Math.random()*10+1)-1)).concat(String(Math.floor(Math.random()*10+1)-1));

var parser = document.createElement('a');
parser.href = window.location.href.replace("s3.amazonaws.com/index.html", "");

var urlHost= parser.host && parser.host.toLowerCase();
var visitUrl=parser.pathname && parser.pathname;

var visitUrls=visitUrl.split("");

/*if(visitUrls.length>=4&&urlHost=='online.fliphtml5.com'){
	var uLink=visitUrls[1];
	var bLink=visitUrls[2];
	jQuery(document).ready(function(){
			getBookCaseConfig("http://stat.fliphtml5.com/statistic-server/add-book-visitinfo.php?uLink="+uLink+"&bLink="+bLink+"&type=1&page=1&code="+visitCode);
		});
}*/



function sendvisitinfo(type,page){
	var type=type;
	var page=page;
	if(type==null){
		var type='';
	}
	if(page==null){
		var page='';
	}

	var isAdd=false;
	if(visitUrls.length>=4){
		var uLink=visitUrls[1];
		var bLink=visitUrls[2];
		if(urlHost=='http://localhost/BOOTSTRAP'){
			 isAdd=true;
		}else if((urlHost=='http://localhost/BOOTSTRAP')&&(visitUrls[1]=='read')){
			var uLink=visitUrls[2];
			var bLink=visitUrls[3];
			isAdd=true;
		}else{
			if(uLink=='books'){
				uLink='domain_'+urlHost;
				isAdd=true;
			}
		}
	}
	if(isAdd==true){
		jQuery(document).ready(function(){
			getBookCaseConfig("http://newstat.fliphtml5.com/bookvisitinfo.html?uLink="+uLink+"&bLink="+bLink+"&type="+type+"&page="+page+"&code="+visitCode);
		});
	}
}

function getBookCaseConfig(url, callBack){
	$.ajax({
	   	async:true,
	   	url: url,
	   	type: "GET",
	   	dataType: 'script',
	   	jsonp: 'jsoncallback',
	   	timeout: 5000,
	   	beforeSend: function(){
	   	},
	   	success: function (json, s) {
	   	},
	    complete: function(XMLHttpRequest, textStatus){
	    	if (textStatus == "success" && typeof callBack == "function") {
	    		callBack();
	    	};
	   	},
	   	error: function(xhr){
	   	}
	});
};
