function checkUrl(form){
	$.get("check.php?n="+escape(form.n.value),function(data,status){
		form.n.value=data;
	});
}
function randomUrl(form){
	const slugchars ="abcdefghijklmnopqrstuvwxyz0123456789";
	form.n.value="";
	for(var i=0;i<8;i++){
		form.n.value += slugchars.charAt(Math.floor(slugchars.length*
		Math.random()));
	}
	checkUrl(form);
}
function logoclick(){
	location.pathname="/";
}
