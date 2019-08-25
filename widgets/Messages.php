<?php
namespace app\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;


class Messages extends Widget
{
    private static $messages = [];
    
    /**
     * {@inheritdoc}
     */
    public function run()
    {
        self::$messages = ArrayHelper::merge(self::$messages, Yii::$app->session->getFlash('messages', []));
        ?>
        <div class="ui tiny modal messages">
            <div class="header">Header</div>
            <div class="content">
                
            </div>
            <div class="actions">
                <div class="ui positive right button">
                    OK
                </div>
            </div>
        </div>
        <script>
            ready(function(){
                var newMessages = <?= Json::encode(self::$messages) ?>;
                if (window.messages) window.messages.push(newMessages);
                else window.messages = newMessages;
                
                var throwMessage = function(message){
                    if (!message) return;
                    if (message.content)
                    {
                        $('.ui.modal.messages > .header').text(message.title || 'Alert');
                        $('.ui.modal.messages > .content').html(message.content || 'Nothing!');
                        
                        $('.ui.modal.messages').modal({
                            closable: message.closable !== undefined ? message.closable : true,
                            duration: message.duration || 300,
                            transition: message.transition || 'fade up',
                            onHidden: function () {
                                throwMessage(messages.shift());
                            }
                        })
                        .modal('show');
                    } else
                    {
                        throwMessage(messages.shift());
                    }
                };

                setTimeout(() => { throwMessage(messages.shift()); }, 100);
            });
        </script>
        <?php
    }
    
    public static function alert($title, $content)
    {
        self::$messages[] = [
            'title' => $title,
            'content' => $content
        ];
    }
    
    public static function alertViaFlash($title, $content)
    {
        Yii::$app->session->addFlash('messages', [
            'title' => $title,
            'content' => $content
        ]);
    }
}
