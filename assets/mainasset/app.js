ready(function(){
    setTimeout(function(){
        initApp();
    }, 500);
   
});

function initApp() {
    
    
    $('.eexe.table.container').each((index, el) => {
        $(el).find('> .content > table.ui.table').floatThead({
            scrollContainer: function($table){
                return $table.parent('.scrolling.content');
            }
        });
    });
    
    repeat(5, 200, 200, function(){
       $(window).resize(); 
    });
}

$(document).on('click', '[data-modal]', function(e){
    e.preventDefault();
    
    $modal = $($(this).data('modal'));
    
    $modal.modal({
        transition: 'fade up'
    })
    .modal('show');
    
    
});

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