$(document).ready(function(){
    $("#next_game").click(function(){
	$.ajax({
	    url: "index.php",
            data:{
		page: "login",
                cmd: "next",
                game_id: $("#id_game").attr("value")
            },
            dataType: 'json',
            success : function(data, state){
                changeGame(data);
            },
            error : function(data, state){
                            
            }
	})
    });

    $("#prev_game").click(function(){
	$.ajax({
	    url: "index.php",
            data:{
		page: "login",
                cmd: "prev",
                game_id: $("#id_game").attr("value")
            },
            dataType: 'json',
            success : function(data, state){
                changeGame(data);
            },
            error : function(data, state){
                            
            }
	})
    });

    function changeGame(game){
        $("#title_game").text(game.title);
        $("#cover_game").attr("src", game.cover);
        $("#id_game").attr("value", game.id);
    }

});
