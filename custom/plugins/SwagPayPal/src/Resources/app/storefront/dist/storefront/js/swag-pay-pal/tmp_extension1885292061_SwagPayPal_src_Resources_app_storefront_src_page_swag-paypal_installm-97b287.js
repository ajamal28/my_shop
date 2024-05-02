"use strict";(self.webpackChunk=self.webpackChunk||[]).push([["tmp_extension1885292061_SwagPayPal_src_Resources_app_storefront_src_page_swag-paypal_installm-97b287"],{857:t=>{var e=function(t){var e;return!!t&&"object"==typeof t&&"[object RegExp]"!==(e=Object.prototype.toString.call(t))&&"[object Date]"!==e&&t.$$typeof!==r},r="function"==typeof Symbol&&Symbol.for?Symbol.for("react.element"):60103;function i(t,e){return!1!==e.clone&&e.isMergeableObject(t)?a(Array.isArray(t)?[]:{},t,e):t}function n(t,e,r){return t.concat(e).map(function(t){return i(t,r)})}function o(t){return Object.keys(t).concat(Object.getOwnPropertySymbols?Object.getOwnPropertySymbols(t).filter(function(e){return Object.propertyIsEnumerable.call(t,e)}):[])}function s(t,e){try{return e in t}catch(t){return!1}}function a(t,r,c){(c=c||{}).arrayMerge=c.arrayMerge||n,c.isMergeableObject=c.isMergeableObject||e,c.cloneUnlessOtherwiseSpecified=i;var l,u,d=Array.isArray(r);return d!==Array.isArray(t)?i(r,c):d?c.arrayMerge(t,r,c):(u={},(l=c).isMergeableObject(t)&&o(t).forEach(function(e){u[e]=i(t[e],l)}),o(r).forEach(function(e){(!s(t,e)||Object.hasOwnProperty.call(t,e)&&Object.propertyIsEnumerable.call(t,e))&&(s(t,e)&&l.isMergeableObject(r[e])?u[e]=(function(t,e){if(!e.customMerge)return a;var r=e.customMerge(t);return"function"==typeof r?r:a})(e,l)(t[e],r[e],l):u[e]=i(r[e],l))}),u)}a.all=function(t,e){if(!Array.isArray(t))throw Error("first argument should be an array");return t.reduce(function(t,r){return a(t,r,e)},{})},t.exports=a},49:(t,e,r)=>{r.d(e,{Z:()=>n});var i=r(140);class n{static isNode(t){return"object"==typeof t&&null!==t&&(t===document||t===window||t instanceof Node)}static hasAttribute(t,e){if(!n.isNode(t))throw Error("The element must be a valid HTML Node!");return"function"==typeof t.hasAttribute&&t.hasAttribute(e)}static getAttribute(t,e){let r=!(arguments.length>2)||void 0===arguments[2]||arguments[2];if(r&&!1===n.hasAttribute(t,e))throw Error('The required property "'.concat(e,'" does not exist!'));if("function"!=typeof t.getAttribute){if(r)throw Error("This node doesn't support the getAttribute function!");return}return t.getAttribute(e)}static getDataAttribute(t,e){let r=!(arguments.length>2)||void 0===arguments[2]||arguments[2],o=e.replace(/^data(|-)/,""),s=i.Z.toLowerCamelCase(o,"-");if(!n.isNode(t)){if(r)throw Error("The passed node is not a valid HTML Node!");return}if(void 0===t.dataset){if(r)throw Error("This node doesn't support the dataset attribute!");return}let a=t.dataset[s];if(void 0===a){if(r)throw Error('The required data attribute "'.concat(e,'" does not exist on ').concat(t,"!"));return a}return i.Z.parsePrimitive(a)}static querySelector(t,e){let r=!(arguments.length>2)||void 0===arguments[2]||arguments[2];if(r&&!n.isNode(t))throw Error("The parent node is not a valid HTML Node!");let i=t.querySelector(e)||!1;if(r&&!1===i)throw Error('The required element "'.concat(e,'" does not exist in parent node!'));return i}static querySelectorAll(t,e){let r=!(arguments.length>2)||void 0===arguments[2]||arguments[2];if(r&&!n.isNode(t))throw Error("The parent node is not a valid HTML Node!");let i=t.querySelectorAll(e);if(0===i.length&&(i=!1),r&&!1===i)throw Error('At least one item of "'.concat(e,'" must exist in parent node!'));return i}}},140:(t,e,r)=>{r.d(e,{Z:()=>i});class i{static ucFirst(t){return t.charAt(0).toUpperCase()+t.slice(1)}static lcFirst(t){return t.charAt(0).toLowerCase()+t.slice(1)}static toDashCase(t){return t.replace(/([A-Z])/g,"-$1").replace(/^-/,"").toLowerCase()}static toLowerCamelCase(t,e){let r=i.toUpperCamelCase(t,e);return i.lcFirst(r)}static toUpperCamelCase(t,e){return e?t.split(e).map(t=>i.ucFirst(t.toLowerCase())).join(""):i.ucFirst(t.toLowerCase())}static parsePrimitive(t){try{return/^\d+(.|,)\d+$/.test(t)&&(t=t.replace(",",".")),JSON.parse(t)}catch(e){return t.toString()}}}},293:(t,e,r)=>{r.d(e,{Z:()=>c});var i=r(857),n=r.n(i),o=r(49),s=r(140);class a{publish(t){let e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{},r=arguments.length>2&&void 0!==arguments[2]&&arguments[2],i=new CustomEvent(t,{detail:e,cancelable:r});return this.el.dispatchEvent(i),i}subscribe(t,e){let r=arguments.length>2&&void 0!==arguments[2]?arguments[2]:{},i=this,n=t.split("."),o=r.scope?e.bind(r.scope):e;if(r.once&&!0===r.once){let e=o;o=function(r){i.unsubscribe(t),e(r)}}return this.el.addEventListener(n[0],o),this.listeners.push({splitEventName:n,opts:r,cb:o}),!0}unsubscribe(t){let e=t.split(".");return this.listeners=this.listeners.reduce((t,r)=>([...r.splitEventName].sort().toString()===e.sort().toString()?this.el.removeEventListener(r.splitEventName[0],r.cb):t.push(r),t),[]),!0}reset(){return this.listeners.forEach(t=>{this.el.removeEventListener(t.splitEventName[0],t.cb)}),this.listeners=[],!0}get el(){return this._el}set el(t){this._el=t}get listeners(){return this._listeners}set listeners(t){this._listeners=t}constructor(t=document){this._el=t,t.$emitter=this,this._listeners=[]}}class c{init(){throw Error('The "init" method for the plugin "'.concat(this._pluginName,'" is not defined.'))}update(){}_init(){this._initialized||(this.init(),this._initialized=!0)}_update(){this._initialized&&this.update()}_mergeOptions(t){let e=s.Z.toDashCase(this._pluginName),r=o.Z.getDataAttribute(this.el,"data-".concat(e,"-config"),!1),i=o.Z.getAttribute(this.el,"data-".concat(e,"-options"),!1),a=[this.constructor.options,this.options,t];r&&a.push(window.PluginConfigManager.get(this._pluginName,r));try{i&&a.push(JSON.parse(i))}catch(t){throw console.error(this.el),Error('The data attribute "data-'.concat(e,'-options" could not be parsed to json: ').concat(t.message))}return n().all(a.filter(t=>t instanceof Object&&!(t instanceof Array)).map(t=>t||{}))}_registerInstance(){window.PluginManager.getPluginInstancesFromElement(this.el).set(this._pluginName,this),window.PluginManager.getPlugin(this._pluginName,!1).get("instances").push(this)}_getPluginName(t){return t||(t=this.constructor.name),t}constructor(t,e={},r=!1){if(!o.Z.isNode(t))throw Error("There is no valid element given.");this.el=t,this.$emitter=new a(this.el),this._pluginName=this._getPluginName(r),this.options=this._mergeOptions(e),this._initialized=!1,this._registerInstance(),this._init()}}},900:(t,e,r)=>{r.r(e),r.d(e,{default:()=>n});var i=r(220);class n extends i.Z{init(){this.createInstallmentBanner()}createInstallmentBanner(){this.createScript(t=>{t.Messages(this.getBannerConfig()).render(this.el)})}getBannerConfig(){var t;return{amount:this.options.amount,buyerCountry:(t=this.options.crossBorderBuyerCountry)!==null&&void 0!==t?t:void 0,currency:this.options.currency,style:{layout:this.options.layout,color:this.options.color,ratio:this.options.ratio,logo:{type:this.options.logoType},text:{color:this.options.textColor}}}}}n.options={clientId:"",merchantPayerId:"",commit:!0,crossBorderBuyerCountry:void 0,amount:0,currency:"EUR",layout:"text",color:"blue",ratio:"8x1",logoType:"primary",textColor:"black",partnerAttributionId:""}},220:(t,e,r)=>{r.d(e,{Z:()=>c});var i=r(293);function n(t,e){void 0===e&&(e={});var r=document.createElement("script");return r.src=t,Object.keys(e).forEach(function(t){r.setAttribute(t,e[t]),"data-csp-nonce"===t&&r.setAttribute("nonce",e["data-csp-nonce"])}),r}function o(t,e){if("object"!=typeof t||null===t)throw Error("Expected an options object.");if(void 0!==e&&"function"!=typeof e)throw Error("Expected PromisePonyfill to be a function.")}var s=r(398);let a=["card","bancontact","blik","eps","giropay","ideal","mybank","p24","sepa","sofort","venmo"];class c extends i.Z{createScript(t){if(null!==this.constructor.scriptLoading.paypal){t.call(this,this.constructor.scriptLoading.paypal);return}this.constructor.scriptLoading.callbacks.push(t),this.constructor.scriptLoading.loadingScript||(this.constructor.scriptLoading.loadingScript=!0,(function(t,e){if(void 0===e&&(e=Promise),o(t,e),"undefined"==typeof document)return e.resolve(null);var r,i,s,a,c,l=(i="https://www.paypal.com/sdk/js",t.sdkBaseUrl&&(i=t.sdkBaseUrl,delete t.sdkBaseUrl),a=(s=Object.keys(t).filter(function(e){return void 0!==t[e]&&null!==t[e]&&""!==t[e]}).reduce(function(e,r){var i=t[r].toString();return"data"===(r=r.replace(/[A-Z]+(?![a-z])|[A-Z]/g,function(t,e){return(e?"-":"")+t.toLowerCase()})).substring(0,4)||"crossorigin"===r?e.attributes[r]=i:e.queryParams[r]=i,e},{queryParams:{},attributes:{}})).queryParams,c=s.attributes,a["merchant-id"]&&-1!==a["merchant-id"].indexOf(",")&&(c["data-merchant-id"]=a["merchant-id"],a["merchant-id"]="*"),{url:"".concat(i,"?").concat((r="",Object.keys(a).forEach(function(t){0!==r.length&&(r+="&"),r+=t+"="+a[t]}),r)),attributes:c}),u=l.url,d=l.attributes,h=d["data-namespace"]||"paypal",p=window[h];return(/*!
 * paypal-js v8.0.0 (2023-12-20T19:17:15.167Z)
 * Copyright 2020-present, PayPal, Inc. All rights reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */function(t,e){var r=document.querySelector('script[src="'.concat(t,'"]'));if(null===r)return null;var i=n(t,e),o=r.cloneNode();if(delete o.dataset.uidAuto,Object.keys(o.dataset).length!==Object.keys(i.dataset).length)return null;var s=!0;return Object.keys(o.dataset).forEach(function(t){o.dataset[t]!==i.dataset[t]&&(s=!1)}),s?r:null}(u,d)&&p?e.resolve(p):(function(t,e){void 0===e&&(e=Promise),o(t,e);var r=t.url,i=t.attributes;if("string"!=typeof r||0===r.length)throw Error("Invalid url.");if(void 0!==i&&"object"!=typeof i)throw Error("Expected attributes to be an object.");return new e(function(t,e){var o,s,a,c,l,u;if("undefined"==typeof document)return t();s=(o={url:r,attributes:i,onSuccess:function(){return t()},onError:function(){return e(Error('The script "'.concat(r,'" failed to load. Check the HTTP status code and response body in DevTools to learn more.')))}}).url,a=o.attributes,c=o.onSuccess,l=o.onError,(u=n(s,a)).onerror=l,u.onload=c,document.head.insertBefore(u,document.head.firstElementChild)})})({url:u,attributes:d},e).then(function(){var t=window[h];if(t)return t;throw Error("The window.".concat(h," global variable is not available."))}))})(this.getScriptOptions()).then(this.callCallbacks.bind(this)))}callCallbacks(){null===this.constructor.scriptLoading.paypal&&(this.constructor.scriptLoading.paypal=window.paypal,delete window.paypal),this.constructor.scriptLoading.callbacks.forEach(t=>{t.call(this,this.constructor.scriptLoading.paypal)})}getScriptOptions(){let t={components:"buttons,messages,card-fields,funding-eligibility","client-id":this.options.clientId,commit:!!this.options.commit,locale:this.options.languageIso,currency:this.options.currency,intent:this.options.intent,"enable-funding":"paylater,venmo"};return(this.options.disablePayLater||!1===this.options.showPayLater)&&(t["enable-funding"]="venmo"),!1===this.options.useAlternativePaymentMethods?t["disable-funding"]=a.join(","):Array.isArray(this.options.disabledAlternativePaymentMethods)&&(t["disable-funding"]=this.options.disabledAlternativePaymentMethods.join(",")),this.options.merchantPayerId&&(t["merchant-id"]=this.options.merchantPayerId),this.options.clientToken&&(t["data-client-token"]=this.options.clientToken),this.options.userIdToken&&(t["data-user-id-token"]=this.options.userIdToken),this.options.partnerAttributionId&&(t["data-partner-attribution-id"]=this.options.partnerAttributionId),t}createError(t){let e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:void 0,r=arguments.length>2&&void 0!==arguments[2]?arguments[2]:"",i=this.options.addErrorUrl;if(this.options.accountOrderEditCancelledUrl&&this.options.accountOrderEditFailedUrl){window.location="cancel"===t?this.options.accountOrderEditCancelledUrl:this.options.accountOrderEditFailedUrl;return}e&&"string"!=typeof e&&(e=String(e)),this._client.post(i,JSON.stringify({error:e,type:t}),()=>{if(r){window.location=r;return}window.onbeforeunload=()=>{window.scrollTo(0,0)},window.location.reload()})}}c.scriptLoading=new s.Z},398:(t,e,r)=>{r.d(e,{Z:()=>i});class i{constructor(){this.loadingScript=!1,this.paypal=null,this.callbacks=[]}}}}]);