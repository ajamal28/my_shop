(window["webpackJsonpPluginswag-pay-pal"]=window["webpackJsonpPluginswag-pay-pal"]||[]).push([[121],{6116:function(){},4251:function(e,n,t){"use strict";t.d(n,{c8:function(){return a},m7:function(){return s}});let a="1ce0868f406d47d98cfe4b281e62f099",s="paypalPosSalesChannel"},5121:function(e,n,t){"use strict";t.r(n),t(9168);var a=t(4251);let{Component:s}=Shopware;s.override("sw-sales-channel-modal-grid",{template:'{% block sw_sales_channel_grid_columns_icon %}\n    <sw-grid-column\n            v-if="isPayPalPosSalesChannel(item.id)"\n            flex="85px"\n            data-index="icon"\n            class="sw-sales-channel-modal-grid__icon-column"\n            label="icon">\n        <span\n            class="sw-sales-channel-modal-grid__icon"\n            role="button"\n            tabindex="0"\n            @click="onOpenDetail(item.id)"\n            @keydown.enter="onOpenDetail(item.id)"\n        >\n             <img class="swag-paypal-pos-modal-grid__icon"\n                  :src="assetFilter(\'swagpaypal/static/img/paypal-pos-logo.svg\')">\n        </span>\n    </sw-grid-column>\n\n    <template v-else>\n        {% parent %}\n    </template>\n{% endblock %}\n\n',methods:{isPayPalPosSalesChannel(e){return this.salesChannelTypes.find(n=>n.id===e).id===a.c8}},computed:{assetFilter(){return Shopware.Filter.getByName("asset")}}})},9168:function(e,n,t){var a=t(6116);a.__esModule&&(a=a.default),"string"==typeof a&&(a=[[e.id,a,""]]),a.locals&&(e.exports=a.locals),t(5346).Z("90bdb4c4",a,!0,{})},5346:function(e,n,t){"use strict";function a(e,n){for(var t=[],a={},s=0;s<n.length;s++){var r=n[s],i=r[0],o={id:e+":"+s,css:r[1],media:r[2],sourceMap:r[3]};a[i]?a[i].parts.push(o):t.push(a[i]={id:i,parts:[o]})}return t}t.d(n,{Z:function(){return h}});var s="undefined"!=typeof document;if("undefined"!=typeof DEBUG&&DEBUG&&!s)throw Error("vue-style-loader cannot be used in a non-browser environment. Use { target: 'node' } in your Webpack config to indicate a server-rendering environment.");var r={},i=s&&(document.head||document.getElementsByTagName("head")[0]),o=null,l=0,d=!1,c=function(){},u=null,p="data-vue-ssr-id",f="undefined"!=typeof navigator&&/msie [6-9]\b/.test(navigator.userAgent.toLowerCase());function h(e,n,t,s){d=t,u=s||{};var i=a(e,n);return m(i),function(n){for(var t=[],s=0;s<i.length;s++){var o=r[i[s].id];o.refs--,t.push(o)}n?m(i=a(e,n)):i=[];for(var s=0;s<t.length;s++){var o=t[s];if(0===o.refs){for(var l=0;l<o.parts.length;l++)o.parts[l]();delete r[o.id]}}}}function m(e){for(var n=0;n<e.length;n++){var t=e[n],a=r[t.id];if(a){a.refs++;for(var s=0;s<a.parts.length;s++)a.parts[s](t.parts[s]);for(;s<t.parts.length;s++)a.parts.push(v(t.parts[s]));a.parts.length>t.parts.length&&(a.parts.length=t.parts.length)}else{for(var i=[],s=0;s<t.parts.length;s++)i.push(v(t.parts[s]));r[t.id]={id:t.id,refs:1,parts:i}}}}function g(){var e=document.createElement("style");return e.type="text/css",i.appendChild(e),e}function v(e){var n,t,a=document.querySelector("style["+p+'~="'+e.id+'"]');if(a){if(d)return c;a.parentNode.removeChild(a)}if(f){var s=l++;n=w.bind(null,a=o||(o=g()),s,!1),t=w.bind(null,a,s,!0)}else n=b.bind(null,a=g()),t=function(){a.parentNode.removeChild(a)};return n(e),function(a){a?(a.css!==e.css||a.media!==e.media||a.sourceMap!==e.sourceMap)&&n(e=a):t()}}var y=function(){var e=[];return function(n,t){return e[n]=t,e.filter(Boolean).join("\n")}}();function w(e,n,t,a){var s=t?"":a.css;if(e.styleSheet)e.styleSheet.cssText=y(n,s);else{var r=document.createTextNode(s),i=e.childNodes;i[n]&&e.removeChild(i[n]),i.length?e.insertBefore(r,i[n]):e.appendChild(r)}}function b(e,n){var t=n.css,a=n.media,s=n.sourceMap;if(a&&e.setAttribute("media",a),u.ssrId&&e.setAttribute(p,n.id),s&&(t+="\n/*# sourceURL="+s.sources[0]+" */\n/*# sourceMappingURL=data:application/json;base64,"+btoa(unescape(encodeURIComponent(JSON.stringify(s))))+" */"),e.styleSheet)e.styleSheet.cssText=t;else{for(;e.firstChild;)e.removeChild(e.firstChild);e.appendChild(document.createTextNode(t))}}}}]);