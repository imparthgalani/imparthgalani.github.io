<?php
/**
 * Ripple icon html and css.
 *
 */

 ?>

 <div class="lds-css ng-scope">
   <div class="lds-ripple preloader-plus-default-icons">
     <div></div>
     <div></div>
   </div>
 <style type="text/css">@keyframes lds-ripple {
   0% {
 		transform: scale(0);
     opacity: 1;
   }
   100% {
     transform: scale(1);
     opacity: 0;
   }
 }
 @-webkit-keyframes lds-ripple {
   0% {
 		transform: scale(0);
     opacity: 1;
   }
   100% {
 		transform: scale(1);
     opacity: 0;
   }
 }
 .lds-ripple {
   position: relative;
 }
 .lds-ripple div {
   box-sizing: content-box;
   position: absolute;
 	 width:100%;
 	 height:100%;
   border-width: 4px;
   border-style: solid;
   opacity: 1;
   border-radius: 50%;
   -webkit-animation: lds-ripple 1s cubic-bezier(0, 0.2, 0.8, 1) infinite;
   animation: lds-ripple 1s cubic-bezier(0, 0.2, 0.8, 1) infinite;
 }
 .lds-ripple div:nth-child(1) {
   border-color: <?php echo esc_attr( $settings['text_color'] ) ?>;
 }
 .lds-ripple div:nth-child(2) {
   border-color: <?php echo esc_attr( $settings['text_color'] ) ?>;
   -webkit-animation-delay: -0.5s;
   animation-delay: -0.5s;
 }
 .lds-ripple {
   -webkit-transform: translate(-100px, -100px) scale(1) translate(100px, 100px);
   transform: translate(-100px, -100px) scale(1) translate(100px, 100px);
 }
 </style></div>
