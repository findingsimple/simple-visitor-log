//     uuid.js
//
//     Copyright (c) 2010-2012 Robert Kieffer
//     MIT License - http://opensource.org/licenses/mit-license.php
(function(){function l(e,t,n){var r=t&&n||0,i=0;t=t||[];e.toLowerCase().replace(/[0-9a-f]{2}/g,function(e){if(i<16){t[r+i++]=a[e]}});while(i<16){t[r+i++]=0}return t}function c(e,t){var n=t||0,r=u;return r[e[n++]]+r[e[n++]]+r[e[n++]]+r[e[n++]]+"-"+r[e[n++]]+r[e[n++]]+"-"+r[e[n++]]+r[e[n++]]+"-"+r[e[n++]]+r[e[n++]]+"-"+r[e[n++]]+r[e[n++]]+r[e[n++]]+r[e[n++]]+r[e[n++]]+r[e[n++]]}function g(e,t,n){var r=t&&n||0;var i=t||[];e=e||{};var s=e.clockseq!=null?e.clockseq:d;var o=e.msecs!=null?e.msecs:(new Date).getTime();var u=e.nsecs!=null?e.nsecs:m+1;var a=o-v+(u-m)/1e4;if(a<0&&e.clockseq==null){s=s+1&16383}if((a<0||o>v)&&e.nsecs==null){u=0}if(u>=1e4){throw new Error("uuid.v1(): Can't create more than 10M uuids/sec")}v=o;m=u;d=s;o+=122192928e5;var f=((o&268435455)*1e4+u)%4294967296;i[r++]=f>>>24&255;i[r++]=f>>>16&255;i[r++]=f>>>8&255;i[r++]=f&255;var l=o/4294967296*1e4&268435455;i[r++]=l>>>8&255;i[r++]=l&255;i[r++]=l>>>24&15|16;i[r++]=l>>>16&255;i[r++]=s>>>8|128;i[r++]=s&255;var h=e.node||p;for(var g=0;g<6;g++){i[r+g]=h[g]}return t?t:c(i)}function y(e,n,r){var i=n&&r||0;if(typeof e=="string"){n=e=="binary"?new o(16):null;e=null}e=e||{};var s=e.random||(e.rng||t)();s[6]=s[6]&15|64;s[8]=s[8]&63|128;if(n){for(var u=0;u<16;u++){n[i+u]=s[u]}}return n||c(s)}var e=this;var t;if(typeof require=="function"){try{var n=require("crypto").randomBytes;t=n&&function(){return n(16)}}catch(r){}}if(!t&&e.crypto&&crypto.getRandomValues){var i=new Uint8Array(16);t=function(){crypto.getRandomValues(i);return i}}if(!t){var s=new Array(16);t=function(){for(var e=0,t;e<16;e++){if((e&3)===0)t=Math.random()*4294967296;s[e]=t>>>((e&3)<<3)&255}return s}}var o=typeof Buffer=="function"?Buffer:Array;var u=[];var a={};for(var f=0;f<256;f++){u[f]=(f+256).toString(16).substr(1);a[u[f]]=f}var h=t();var p=[h[0]|1,h[1],h[2],h[3],h[4],h[5]];var d=(h[6]<<8|h[7])&16383;var v=0,m=0;var b=y;b.v1=g;b.v4=y;b.parse=l;b.unparse=c;b.BufferClass=o;if(typeof define==="function"&&define.amd){define(function(){return b})}else if(typeof module!="undefined"&&module.exports){module.exports=b}else{var w=e.uuid;b.noConflict=function(){e.uuid=w;return b};e.uuid=b}}).call(this)

var uuid;
var uuid_set = jQuery.cookie('svl_visitor[uuid]');

if ( uuid_set == undefined ) {
	/* if no existing uuid generate a new uuid and set a new cookie */
	uuid = uuid.v4(); 
	jQuery.cookie( 'svl_visitor[uuid]' , uuid , { expires: 730, path: '/' });
} else {
	/* use the existing uuid */
	uuid = uuid_set; 
}

/* log the visit */
svl_log_visit();

/**
 * Function for logging the user visit via ajax
 */
function svl_log_visit() {

	jQuery.ajax({

		type: 'POST',
		url: LogVisit.ajaxurl,
		data: {
			'action': 'svl-log-visit', 
			'post_id' : LogVisit.post_id,
			'nonce': LogVisit.wpnonce 
		},
		dataType: 'JSON',
		success: function( data, textStatus, XMLHttpRequest ) {
			//alert('Logged');
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			console.log( errorThrown );
		},
		complete: function(XMLHttpRequest, textStatus) {
			//something
		}

	});

}