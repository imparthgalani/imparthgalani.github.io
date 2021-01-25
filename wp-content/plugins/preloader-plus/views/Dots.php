<?php
/**
 * Interwind icon html and css.
 *
 */

 ?>

 <div class="lds-css ng-scope">
   <div class="lds-dots preloader-plus-default-icons">
     <div></div>
     <div></div>
     <div></div>
     <div></div>
   </div>
 <style type="text/css">@keyframes lds-dots {
   0% {
     opacity: 1;
		 transform:scale(1);
   }
	 50% {
     opacity: 1;
		 transform:scale(0.5);
   }
   100% {
     opacity: 1;
		 transform:scale(0.5);
   }
 }
 @-webkit-keyframes lds-dots {
   0% {
     opacity: 0;
   }
   50% {
     opacity: 0.5;
   }
   100% {
     opacity: 1;
   }
 }
 .lds-dots div {
   width: 20%;
   height: 20%;
	 border-radius: 50%;
	 transform:scale(0.5);
   -webkit-animation: lds-dots 1s linear infinite;
   animation: lds-dots 1s linear infinite;
 }
 .lds-dots div:nth-child(1) {
   background: <?php echo esc_attr( $settings['text_color'] ) ?>;
   -webkit-animation-delay: 0.25s;
   animation-delay: 0.25s;
 }
 .lds-dots div:nth-child(2) {
   background: <?php echo esc_attr( $settings['text_color'] ) ?>;
   -webkit-animation-delay: 0.5s;
   animation-delay: 0.5s;
 }
 .lds-dots div:nth-child(3) {
   background: <?php echo esc_attr( $settings['text_color'] ) ?>;
   -webkit-animation-delay: 0.75s;
   animation-delay: 0.75s;
 }
 .lds-dots div:nth-child(4) {
   background: <?php echo esc_attr( $settings['text_color'] ) ?>;
	 -webkit-animation-delay: 1s;
	 animation-delay: 1s;
 }
 .lds-dots {
	 display: flex;
 	 flex-flow: row nowrap;
 	 align-items: center;
 	 justify-content: space-between;
 }
 </style></div>
