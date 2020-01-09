<?php 
//订单发送到Telegram
add_action( 'woocommerce_new_order', 'wt_send_to_telegram',  1, 1  );
function wt_send_to_telegram( $order_id ) {
  $order = wc_get_order( $order_id );
  $items = $order->get_items();
  foreach ( $items as $item ) {
  $product_name .= $item['name'];
  }
  $botToken="878519964:AAEqtkWNqLVaqhevZYukm4xVMdL0mLlvkrI";
  $website="https://api.telegram.org/bot".$botToken;
  $chatId=134125618;
  $info = "编号：".$order->id."\n产品: ".$product_name."\n邮箱: ".$order->billing_email."\n金额: ".$order->currency." ".$order->total;
  $params=[
      'chat_id'=>$chatId, 
      'text'=>"新订单:".$order->total."元\n\n".$info,
  ];
  $ch = curl_init($website . '/sendMessage');
  curl_setopt($ch, CURLOPT_HEADER, false);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, ($params));
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  $result = curl_exec($ch);
  curl_close($ch);

}
?>
