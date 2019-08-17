ready(function(){
    setTimeout(function(){
        initApp();
    }, 500);
   
});

function initApp() {
    
    
    $('.eexe.table.container').each((index, el) => {
        $(el).find('> .content > table.ui.table').floatThead({
            scrollContainer: function($table){
                        console.log($table.parent('.scrolling.content'));
                return $table.parent('.scrolling.content');
            }
        });
    });
    
    repeat(10, 200, 200, function(){
       $(window).resize(); 
    });
}

function repeat(times, interval, delay, callback)
{
    if (times > 0)
        setTimeout(function(){
            callback();
            setTimeout(function(){
                repeat(--times, interval, 0, callback);
            }, interval);
        }, delay);
}