import{d as an,c as $,w as rn,h as on}from"./@vue-C4Ig4sz1.js";const qt=()=>{};let Dt={},we={},ke=null,Oe={mark:qt,measure:qt};try{typeof window<"u"&&(Dt=window),typeof document<"u"&&(we=document),typeof MutationObserver<"u"&&(ke=MutationObserver),typeof performance<"u"&&(Oe=performance)}catch{}const{userAgent:Qt=""}=Dt.navigator||{},j=Dt,h=we,Zt=ke,lt=Oe;j.document;const L=!!h.documentElement&&!!h.head&&typeof h.addEventListener=="function"&&typeof h.createElement=="function",Se=~Qt.indexOf("MSIE")||~Qt.indexOf("Trident/");var b="classic",Pe="duotone",k="sharp",O="sharp-duotone",sn=[b,Pe,k,O],ln={classic:{900:"fas",400:"far",normal:"far",300:"fal",100:"fat"},sharp:{900:"fass",400:"fasr",300:"fasl",100:"fast"},"sharp-duotone":{900:"fasds"}},Jt={kit:{fak:"kit","fa-kit":"kit"},"kit-duotone":{fakd:"kit-duotone","fa-kit-duotone":"kit-duotone"}},cn=["kit"],fn=/fa(s|r|l|t|d|b|k|kd|ss|sr|sl|st|sds)?[\-\ ]/,un=/Font ?Awesome ?([56 ]*)(Solid|Regular|Light|Thin|Duotone|Brands|Free|Pro|Sharp Duotone|Sharp|Kit)?.*/i,mn={"Font Awesome 5 Free":{900:"fas",400:"far"},"Font Awesome 5 Pro":{900:"fas",400:"far",normal:"far",300:"fal"},"Font Awesome 5 Brands":{400:"fab",normal:"fab"},"Font Awesome 5 Duotone":{900:"fad"}},dn={"Font Awesome 6 Free":{900:"fas",400:"far"},"Font Awesome 6 Pro":{900:"fas",400:"far",normal:"far",300:"fal",100:"fat"},"Font Awesome 6 Brands":{400:"fab",normal:"fab"},"Font Awesome 6 Duotone":{900:"fad"},"Font Awesome 6 Sharp":{900:"fass",400:"fasr",normal:"fasr",300:"fasl",100:"fast"},"Font Awesome 6 Sharp Duotone":{900:"fasds"}},pn={classic:{"fa-brands":"fab","fa-duotone":"fad","fa-light":"fal","fa-regular":"far","fa-solid":"fas","fa-thin":"fat"},sharp:{"fa-solid":"fass","fa-regular":"fasr","fa-light":"fasl","fa-thin":"fast"},"sharp-duotone":{"fa-solid":"fasds"}},gn={classic:["fas","far","fal","fat"],sharp:["fass","fasr","fasl","fast"],"sharp-duotone":["fasds"]},hn={classic:{fab:"fa-brands",fad:"fa-duotone",fal:"fa-light",far:"fa-regular",fas:"fa-solid",fat:"fa-thin"},sharp:{fass:"fa-solid",fasr:"fa-regular",fasl:"fa-light",fast:"fa-thin"},"sharp-duotone":{fasds:"fa-solid"}},bn={classic:{solid:"fas",regular:"far",light:"fal",thin:"fat",duotone:"fad",brands:"fab"},sharp:{solid:"fass",regular:"fasr",light:"fasl",thin:"fast"},"sharp-duotone":{solid:"fasds"}},Ee={classic:{fa:"solid",fas:"solid","fa-solid":"solid",far:"regular","fa-regular":"regular",fal:"light","fa-light":"light",fat:"thin","fa-thin":"thin",fad:"duotone","fa-duotone":"duotone",fab:"brands","fa-brands":"brands"},sharp:{fa:"solid",fass:"solid","fa-solid":"solid",fasr:"regular","fa-regular":"regular",fasl:"light","fa-light":"light",fast:"thin","fa-thin":"thin"},"sharp-duotone":{fa:"solid",fasds:"solid","fa-solid":"solid"}},yn=["solid","regular","light","thin","duotone","brands"],Ce=[1,2,3,4,5,6,7,8,9,10],vn=Ce.concat([11,12,13,14,15,16,17,18,19,20]),J={GROUP:"duotone-group",SWAP_OPACITY:"swap-opacity",PRIMARY:"primary",SECONDARY:"secondary"},xn=[...Object.keys(gn),...yn,"2xs","xs","sm","lg","xl","2xl","beat","border","fade","beat-fade","bounce","flip-both","flip-horizontal","flip-vertical","flip","fw","inverse","layers-counter","layers-text","layers","li","pull-left","pull-right","pulse","rotate-180","rotate-270","rotate-90","rotate-by","shake","spin-pulse","spin-reverse","spin","stack-1x","stack-2x","stack","ul",J.GROUP,J.SWAP_OPACITY,J.PRIMARY,J.SECONDARY].concat(Ce.map(t=>"".concat(t,"x"))).concat(vn.map(t=>"w-".concat(t))),An={"Font Awesome Kit":{400:"fak",normal:"fak"},"Font Awesome Kit Duotone":{400:"fakd",normal:"fakd"}},wn={kit:{"fa-kit":"fak"},"kit-duotone":{"fa-kit-duotone":"fakd"}},kn={kit:{fak:"fa-kit"},"kit-duotone":{fakd:"fa-kit-duotone"}},te={kit:{kit:"fak"},"kit-duotone":{"kit-duotone":"fakd"}};const M="___FONT_AWESOME___",Ot=16,Ne="fa",Ie="svg-inline--fa",X="data-fa-i2svg",St="data-fa-pseudo-element",On="data-fa-pseudo-element-pending",Yt="data-prefix",Ut="data-icon",ee="fontawesome-i2svg",Sn="async",Pn=["HTML","HEAD","STYLE","SCRIPT"],_e=(()=>{try{return!0}catch{return!1}})(),Te=[b,k,O];function it(t){return new Proxy(t,{get(e,n){return n in e?e[n]:e[b]}})}const Me={...Ee};Me[b]={...Ee[b],...Jt.kit,...Jt["kit-duotone"]};const W=it(Me),Pt={...bn};Pt[b]={...Pt[b],...te.kit,...te["kit-duotone"]};const at=it(Pt),Et={...hn};Et[b]={...Et[b],...kn.kit};const G=it(Et),Ct={...pn};Ct[b]={...Ct[b],...wn.kit};const En=it(Ct),Cn=fn,Fe="fa-layers-text",Nn=un,In={...ln};it(In);const _n=["class","data-prefix","data-icon","data-fa-transform","data-fa-mask"],yt=J,q=new Set;Object.keys(at[b]).map(q.add.bind(q));Object.keys(at[k]).map(q.add.bind(q));Object.keys(at[O]).map(q.add.bind(q));const Tn=[...cn,...xn],et=j.FontAwesomeConfig||{};function Mn(t){var e=h.querySelector("script["+t+"]");if(e)return e.getAttribute(t)}function Fn(t){return t===""?!0:t==="false"?!1:t==="true"?!0:t}h&&typeof h.querySelector=="function"&&[["data-family-prefix","familyPrefix"],["data-css-prefix","cssPrefix"],["data-family-default","familyDefault"],["data-style-default","styleDefault"],["data-replacement-class","replacementClass"],["data-auto-replace-svg","autoReplaceSvg"],["data-auto-add-css","autoAddCss"],["data-auto-a11y","autoA11y"],["data-search-pseudo-elements","searchPseudoElements"],["data-observe-mutations","observeMutations"],["data-mutate-approach","mutateApproach"],["data-keep-original-source","keepOriginalSource"],["data-measure-performance","measurePerformance"],["data-show-missing-icons","showMissingIcons"]].forEach(e=>{let[n,a]=e;const r=Fn(Mn(n));r!=null&&(et[a]=r)});const Le={styleDefault:"solid",familyDefault:"classic",cssPrefix:Ne,replacementClass:Ie,autoReplaceSvg:!0,autoAddCss:!0,autoA11y:!0,searchPseudoElements:!1,observeMutations:!0,mutateApproach:"async",keepOriginalSource:!0,measurePerformance:!1,showMissingIcons:!0};et.familyPrefix&&(et.cssPrefix=et.familyPrefix);const Q={...Le,...et};Q.autoReplaceSvg||(Q.observeMutations=!1);const f={};Object.keys(Le).forEach(t=>{Object.defineProperty(f,t,{enumerable:!0,set:function(e){Q[t]=e,nt.forEach(n=>n(f))},get:function(){return Q[t]}})});Object.defineProperty(f,"familyPrefix",{enumerable:!0,set:function(t){Q.cssPrefix=t,nt.forEach(e=>e(f))},get:function(){return Q.cssPrefix}});j.FontAwesomeConfig=f;const nt=[];function Ln(t){return nt.push(t),()=>{nt.splice(nt.indexOf(t),1)}}const z=Ot,N={size:16,x:0,y:0,rotate:0,flipX:!1,flipY:!1};function zn(t){if(!t||!L)return;const e=h.createElement("style");e.setAttribute("type","text/css"),e.innerHTML=t;const n=h.head.childNodes;let a=null;for(let r=n.length-1;r>-1;r--){const i=n[r],o=(i.tagName||"").toUpperCase();["STYLE","LINK"].indexOf(o)>-1&&(a=i)}return h.head.insertBefore(e,a),t}const Rn="0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";function rt(){let t=12,e="";for(;t-- >0;)e+=Rn[Math.random()*62|0];return e}function Z(t){const e=[];for(let n=(t||[]).length>>>0;n--;)e[n]=t[n];return e}function Bt(t){return t.classList?Z(t.classList):(t.getAttribute("class")||"").split(" ").filter(e=>e)}function ze(t){return"".concat(t).replace(/&/g,"&amp;").replace(/"/g,"&quot;").replace(/'/g,"&#39;").replace(/</g,"&lt;").replace(/>/g,"&gt;")}function jn(t){return Object.keys(t||{}).reduce((e,n)=>e+"".concat(n,'="').concat(ze(t[n]),'" '),"").trim()}function pt(t){return Object.keys(t||{}).reduce((e,n)=>e+"".concat(n,": ").concat(t[n].trim(),";"),"")}function Wt(t){return t.size!==N.size||t.x!==N.x||t.y!==N.y||t.rotate!==N.rotate||t.flipX||t.flipY}function Dn(t){let{transform:e,containerWidth:n,iconWidth:a}=t;const r={transform:"translate(".concat(n/2," 256)")},i="translate(".concat(e.x*32,", ").concat(e.y*32,") "),o="scale(".concat(e.size/16*(e.flipX?-1:1),", ").concat(e.size/16*(e.flipY?-1:1),") "),s="rotate(".concat(e.rotate," 0 0)"),l={transform:"".concat(i," ").concat(o," ").concat(s)},c={transform:"translate(".concat(a/2*-1," -256)")};return{outer:r,inner:l,path:c}}function Yn(t){let{transform:e,width:n=Ot,height:a=Ot,startCentered:r=!1}=t,i="";return r&&Se?i+="translate(".concat(e.x/z-n/2,"em, ").concat(e.y/z-a/2,"em) "):r?i+="translate(calc(-50% + ".concat(e.x/z,"em), calc(-50% + ").concat(e.y/z,"em)) "):i+="translate(".concat(e.x/z,"em, ").concat(e.y/z,"em) "),i+="scale(".concat(e.size/z*(e.flipX?-1:1),", ").concat(e.size/z*(e.flipY?-1:1),") "),i+="rotate(".concat(e.rotate,"deg) "),i}var Un=`:root, :host {
  --fa-font-solid: normal 900 1em/1 "Font Awesome 6 Free";
  --fa-font-regular: normal 400 1em/1 "Font Awesome 6 Free";
  --fa-font-light: normal 300 1em/1 "Font Awesome 6 Pro";
  --fa-font-thin: normal 100 1em/1 "Font Awesome 6 Pro";
  --fa-font-duotone: normal 900 1em/1 "Font Awesome 6 Duotone";
  --fa-font-brands: normal 400 1em/1 "Font Awesome 6 Brands";
  --fa-font-sharp-solid: normal 900 1em/1 "Font Awesome 6 Sharp";
  --fa-font-sharp-regular: normal 400 1em/1 "Font Awesome 6 Sharp";
  --fa-font-sharp-light: normal 300 1em/1 "Font Awesome 6 Sharp";
  --fa-font-sharp-thin: normal 100 1em/1 "Font Awesome 6 Sharp";
  --fa-font-sharp-duotone-solid: normal 900 1em/1 "Font Awesome 6 Sharp Duotone";
}

svg:not(:root).svg-inline--fa, svg:not(:host).svg-inline--fa {
  overflow: visible;
  box-sizing: content-box;
}

.svg-inline--fa {
  display: var(--fa-display, inline-block);
  height: 1em;
  overflow: visible;
  vertical-align: -0.125em;
}
.svg-inline--fa.fa-2xs {
  vertical-align: 0.1em;
}
.svg-inline--fa.fa-xs {
  vertical-align: 0em;
}
.svg-inline--fa.fa-sm {
  vertical-align: -0.0714285705em;
}
.svg-inline--fa.fa-lg {
  vertical-align: -0.2em;
}
.svg-inline--fa.fa-xl {
  vertical-align: -0.25em;
}
.svg-inline--fa.fa-2xl {
  vertical-align: -0.3125em;
}
.svg-inline--fa.fa-pull-left {
  margin-right: var(--fa-pull-margin, 0.3em);
  width: auto;
}
.svg-inline--fa.fa-pull-right {
  margin-left: var(--fa-pull-margin, 0.3em);
  width: auto;
}
.svg-inline--fa.fa-li {
  width: var(--fa-li-width, 2em);
  top: 0.25em;
}
.svg-inline--fa.fa-fw {
  width: var(--fa-fw-width, 1.25em);
}

.fa-layers svg.svg-inline--fa {
  bottom: 0;
  left: 0;
  margin: auto;
  position: absolute;
  right: 0;
  top: 0;
}

.fa-layers-counter, .fa-layers-text {
  display: inline-block;
  position: absolute;
  text-align: center;
}

.fa-layers {
  display: inline-block;
  height: 1em;
  position: relative;
  text-align: center;
  vertical-align: -0.125em;
  width: 1em;
}
.fa-layers svg.svg-inline--fa {
  transform-origin: center center;
}

.fa-layers-text {
  left: 50%;
  top: 50%;
  transform: translate(-50%, -50%);
  transform-origin: center center;
}

.fa-layers-counter {
  background-color: var(--fa-counter-background-color, #ff253a);
  border-radius: var(--fa-counter-border-radius, 1em);
  box-sizing: border-box;
  color: var(--fa-inverse, #fff);
  line-height: var(--fa-counter-line-height, 1);
  max-width: var(--fa-counter-max-width, 5em);
  min-width: var(--fa-counter-min-width, 1.5em);
  overflow: hidden;
  padding: var(--fa-counter-padding, 0.25em 0.5em);
  right: var(--fa-right, 0);
  text-overflow: ellipsis;
  top: var(--fa-top, 0);
  transform: scale(var(--fa-counter-scale, 0.25));
  transform-origin: top right;
}

.fa-layers-bottom-right {
  bottom: var(--fa-bottom, 0);
  right: var(--fa-right, 0);
  top: auto;
  transform: scale(var(--fa-layers-scale, 0.25));
  transform-origin: bottom right;
}

.fa-layers-bottom-left {
  bottom: var(--fa-bottom, 0);
  left: var(--fa-left, 0);
  right: auto;
  top: auto;
  transform: scale(var(--fa-layers-scale, 0.25));
  transform-origin: bottom left;
}

.fa-layers-top-right {
  top: var(--fa-top, 0);
  right: var(--fa-right, 0);
  transform: scale(var(--fa-layers-scale, 0.25));
  transform-origin: top right;
}

.fa-layers-top-left {
  left: var(--fa-left, 0);
  right: auto;
  top: var(--fa-top, 0);
  transform: scale(var(--fa-layers-scale, 0.25));
  transform-origin: top left;
}

.fa-1x {
  font-size: 1em;
}

.fa-2x {
  font-size: 2em;
}

.fa-3x {
  font-size: 3em;
}

.fa-4x {
  font-size: 4em;
}

.fa-5x {
  font-size: 5em;
}

.fa-6x {
  font-size: 6em;
}

.fa-7x {
  font-size: 7em;
}

.fa-8x {
  font-size: 8em;
}

.fa-9x {
  font-size: 9em;
}

.fa-10x {
  font-size: 10em;
}

.fa-2xs {
  font-size: 0.625em;
  line-height: 0.1em;
  vertical-align: 0.225em;
}

.fa-xs {
  font-size: 0.75em;
  line-height: 0.0833333337em;
  vertical-align: 0.125em;
}

.fa-sm {
  font-size: 0.875em;
  line-height: 0.0714285718em;
  vertical-align: 0.0535714295em;
}

.fa-lg {
  font-size: 1.25em;
  line-height: 0.05em;
  vertical-align: -0.075em;
}

.fa-xl {
  font-size: 1.5em;
  line-height: 0.0416666682em;
  vertical-align: -0.125em;
}

.fa-2xl {
  font-size: 2em;
  line-height: 0.03125em;
  vertical-align: -0.1875em;
}

.fa-fw {
  text-align: center;
  width: 1.25em;
}

.fa-ul {
  list-style-type: none;
  margin-left: var(--fa-li-margin, 2.5em);
  padding-left: 0;
}
.fa-ul > li {
  position: relative;
}

.fa-li {
  left: calc(-1 * var(--fa-li-width, 2em));
  position: absolute;
  text-align: center;
  width: var(--fa-li-width, 2em);
  line-height: inherit;
}

.fa-border {
  border-color: var(--fa-border-color, #eee);
  border-radius: var(--fa-border-radius, 0.1em);
  border-style: var(--fa-border-style, solid);
  border-width: var(--fa-border-width, 0.08em);
  padding: var(--fa-border-padding, 0.2em 0.25em 0.15em);
}

.fa-pull-left {
  float: left;
  margin-right: var(--fa-pull-margin, 0.3em);
}

.fa-pull-right {
  float: right;
  margin-left: var(--fa-pull-margin, 0.3em);
}

.fa-beat {
  animation-name: fa-beat;
  animation-delay: var(--fa-animation-delay, 0s);
  animation-direction: var(--fa-animation-direction, normal);
  animation-duration: var(--fa-animation-duration, 1s);
  animation-iteration-count: var(--fa-animation-iteration-count, infinite);
  animation-timing-function: var(--fa-animation-timing, ease-in-out);
}

.fa-bounce {
  animation-name: fa-bounce;
  animation-delay: var(--fa-animation-delay, 0s);
  animation-direction: var(--fa-animation-direction, normal);
  animation-duration: var(--fa-animation-duration, 1s);
  animation-iteration-count: var(--fa-animation-iteration-count, infinite);
  animation-timing-function: var(--fa-animation-timing, cubic-bezier(0.28, 0.84, 0.42, 1));
}

.fa-fade {
  animation-name: fa-fade;
  animation-delay: var(--fa-animation-delay, 0s);
  animation-direction: var(--fa-animation-direction, normal);
  animation-duration: var(--fa-animation-duration, 1s);
  animation-iteration-count: var(--fa-animation-iteration-count, infinite);
  animation-timing-function: var(--fa-animation-timing, cubic-bezier(0.4, 0, 0.6, 1));
}

.fa-beat-fade {
  animation-name: fa-beat-fade;
  animation-delay: var(--fa-animation-delay, 0s);
  animation-direction: var(--fa-animation-direction, normal);
  animation-duration: var(--fa-animation-duration, 1s);
  animation-iteration-count: var(--fa-animation-iteration-count, infinite);
  animation-timing-function: var(--fa-animation-timing, cubic-bezier(0.4, 0, 0.6, 1));
}

.fa-flip {
  animation-name: fa-flip;
  animation-delay: var(--fa-animation-delay, 0s);
  animation-direction: var(--fa-animation-direction, normal);
  animation-duration: var(--fa-animation-duration, 1s);
  animation-iteration-count: var(--fa-animation-iteration-count, infinite);
  animation-timing-function: var(--fa-animation-timing, ease-in-out);
}

.fa-shake {
  animation-name: fa-shake;
  animation-delay: var(--fa-animation-delay, 0s);
  animation-direction: var(--fa-animation-direction, normal);
  animation-duration: var(--fa-animation-duration, 1s);
  animation-iteration-count: var(--fa-animation-iteration-count, infinite);
  animation-timing-function: var(--fa-animation-timing, linear);
}

.fa-spin {
  animation-name: fa-spin;
  animation-delay: var(--fa-animation-delay, 0s);
  animation-direction: var(--fa-animation-direction, normal);
  animation-duration: var(--fa-animation-duration, 2s);
  animation-iteration-count: var(--fa-animation-iteration-count, infinite);
  animation-timing-function: var(--fa-animation-timing, linear);
}

.fa-spin-reverse {
  --fa-animation-direction: reverse;
}

.fa-pulse,
.fa-spin-pulse {
  animation-name: fa-spin;
  animation-direction: var(--fa-animation-direction, normal);
  animation-duration: var(--fa-animation-duration, 1s);
  animation-iteration-count: var(--fa-animation-iteration-count, infinite);
  animation-timing-function: var(--fa-animation-timing, steps(8));
}

@media (prefers-reduced-motion: reduce) {
  .fa-beat,
.fa-bounce,
.fa-fade,
.fa-beat-fade,
.fa-flip,
.fa-pulse,
.fa-shake,
.fa-spin,
.fa-spin-pulse {
    animation-delay: -1ms;
    animation-duration: 1ms;
    animation-iteration-count: 1;
    transition-delay: 0s;
    transition-duration: 0s;
  }
}
@keyframes fa-beat {
  0%, 90% {
    transform: scale(1);
  }
  45% {
    transform: scale(var(--fa-beat-scale, 1.25));
  }
}
@keyframes fa-bounce {
  0% {
    transform: scale(1, 1) translateY(0);
  }
  10% {
    transform: scale(var(--fa-bounce-start-scale-x, 1.1), var(--fa-bounce-start-scale-y, 0.9)) translateY(0);
  }
  30% {
    transform: scale(var(--fa-bounce-jump-scale-x, 0.9), var(--fa-bounce-jump-scale-y, 1.1)) translateY(var(--fa-bounce-height, -0.5em));
  }
  50% {
    transform: scale(var(--fa-bounce-land-scale-x, 1.05), var(--fa-bounce-land-scale-y, 0.95)) translateY(0);
  }
  57% {
    transform: scale(1, 1) translateY(var(--fa-bounce-rebound, -0.125em));
  }
  64% {
    transform: scale(1, 1) translateY(0);
  }
  100% {
    transform: scale(1, 1) translateY(0);
  }
}
@keyframes fa-fade {
  50% {
    opacity: var(--fa-fade-opacity, 0.4);
  }
}
@keyframes fa-beat-fade {
  0%, 100% {
    opacity: var(--fa-beat-fade-opacity, 0.4);
    transform: scale(1);
  }
  50% {
    opacity: 1;
    transform: scale(var(--fa-beat-fade-scale, 1.125));
  }
}
@keyframes fa-flip {
  50% {
    transform: rotate3d(var(--fa-flip-x, 0), var(--fa-flip-y, 1), var(--fa-flip-z, 0), var(--fa-flip-angle, -180deg));
  }
}
@keyframes fa-shake {
  0% {
    transform: rotate(-15deg);
  }
  4% {
    transform: rotate(15deg);
  }
  8%, 24% {
    transform: rotate(-18deg);
  }
  12%, 28% {
    transform: rotate(18deg);
  }
  16% {
    transform: rotate(-22deg);
  }
  20% {
    transform: rotate(22deg);
  }
  32% {
    transform: rotate(-12deg);
  }
  36% {
    transform: rotate(12deg);
  }
  40%, 100% {
    transform: rotate(0deg);
  }
}
@keyframes fa-spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
.fa-rotate-90 {
  transform: rotate(90deg);
}

.fa-rotate-180 {
  transform: rotate(180deg);
}

.fa-rotate-270 {
  transform: rotate(270deg);
}

.fa-flip-horizontal {
  transform: scale(-1, 1);
}

.fa-flip-vertical {
  transform: scale(1, -1);
}

.fa-flip-both,
.fa-flip-horizontal.fa-flip-vertical {
  transform: scale(-1, -1);
}

.fa-rotate-by {
  transform: rotate(var(--fa-rotate-angle, 0));
}

.fa-stack {
  display: inline-block;
  vertical-align: middle;
  height: 2em;
  position: relative;
  width: 2.5em;
}

.fa-stack-1x,
.fa-stack-2x {
  bottom: 0;
  left: 0;
  margin: auto;
  position: absolute;
  right: 0;
  top: 0;
  z-index: var(--fa-stack-z-index, auto);
}

.svg-inline--fa.fa-stack-1x {
  height: 1em;
  width: 1.25em;
}
.svg-inline--fa.fa-stack-2x {
  height: 2em;
  width: 2.5em;
}

.fa-inverse {
  color: var(--fa-inverse, #fff);
}

.sr-only,
.fa-sr-only {
  position: absolute;
  width: 1px;
  height: 1px;
  padding: 0;
  margin: -1px;
  overflow: hidden;
  clip: rect(0, 0, 0, 0);
  white-space: nowrap;
  border-width: 0;
}

.sr-only-focusable:not(:focus),
.fa-sr-only-focusable:not(:focus) {
  position: absolute;
  width: 1px;
  height: 1px;
  padding: 0;
  margin: -1px;
  overflow: hidden;
  clip: rect(0, 0, 0, 0);
  white-space: nowrap;
  border-width: 0;
}

.svg-inline--fa .fa-primary {
  fill: var(--fa-primary-color, currentColor);
  opacity: var(--fa-primary-opacity, 1);
}

.svg-inline--fa .fa-secondary {
  fill: var(--fa-secondary-color, currentColor);
  opacity: var(--fa-secondary-opacity, 0.4);
}

.svg-inline--fa.fa-swap-opacity .fa-primary {
  opacity: var(--fa-secondary-opacity, 0.4);
}

.svg-inline--fa.fa-swap-opacity .fa-secondary {
  opacity: var(--fa-primary-opacity, 1);
}

.svg-inline--fa mask .fa-primary,
.svg-inline--fa mask .fa-secondary {
  fill: black;
}

.fad.fa-inverse,
.fa-duotone.fa-inverse {
  color: var(--fa-inverse, #fff);
}`;function Re(){const t=Ne,e=Ie,n=f.cssPrefix,a=f.replacementClass;let r=Un;if(n!==t||a!==e){const i=new RegExp("\\.".concat(t,"\\-"),"g"),o=new RegExp("\\--".concat(t,"\\-"),"g"),s=new RegExp("\\.".concat(e),"g");r=r.replace(i,".".concat(n,"-")).replace(o,"--".concat(n,"-")).replace(s,".".concat(a))}return r}let ne=!1;function vt(){f.autoAddCss&&!ne&&(zn(Re()),ne=!0)}var Bn={mixout(){return{dom:{css:Re,insertCss:vt}}},hooks(){return{beforeDOMElementCreation(){vt()},beforeI2svg(){vt()}}}};const F=j||{};F[M]||(F[M]={});F[M].styles||(F[M].styles={});F[M].hooks||(F[M].hooks={});F[M].shims||(F[M].shims=[]);var I=F[M];const je=[],De=function(){h.removeEventListener("DOMContentLoaded",De),ut=1,je.map(t=>t())};let ut=!1;L&&(ut=(h.documentElement.doScroll?/^loaded|^c/:/^loaded|^i|^c/).test(h.readyState),ut||h.addEventListener("DOMContentLoaded",De));function Wn(t){L&&(ut?setTimeout(t,0):je.push(t))}function ot(t){const{tag:e,attributes:n={},children:a=[]}=t;return typeof t=="string"?ze(t):"<".concat(e," ").concat(jn(n),">").concat(a.map(ot).join(""),"</").concat(e,">")}function ae(t,e,n){if(t&&t[e]&&t[e][n])return{prefix:e,iconName:n,icon:t[e][n]}}var xt=function(e,n,a,r){var i=Object.keys(e),o=i.length,s=n,l,c,m;for(a===void 0?(l=1,m=e[i[0]]):(l=0,m=a);l<o;l++)c=i[l],m=s(m,e[c],c,e);return m};function Gn(t){const e=[];let n=0;const a=t.length;for(;n<a;){const r=t.charCodeAt(n++);if(r>=55296&&r<=56319&&n<a){const i=t.charCodeAt(n++);(i&64512)==56320?e.push(((r&1023)<<10)+(i&1023)+65536):(e.push(r),n--)}else e.push(r)}return e}function Nt(t){const e=Gn(t);return e.length===1?e[0].toString(16):null}function Xn(t,e){const n=t.length;let a=t.charCodeAt(e),r;return a>=55296&&a<=56319&&n>e+1&&(r=t.charCodeAt(e+1),r>=56320&&r<=57343)?(a-55296)*1024+r-56320+65536:a}function re(t){return Object.keys(t).reduce((e,n)=>{const a=t[n];return!!a.icon?e[a.iconName]=a.icon:e[n]=a,e},{})}function It(t,e){let n=arguments.length>2&&arguments[2]!==void 0?arguments[2]:{};const{skipHooks:a=!1}=n,r=re(e);typeof I.hooks.addPack=="function"&&!a?I.hooks.addPack(t,re(e)):I.styles[t]={...I.styles[t]||{},...r},t==="fas"&&It("fa",e)}const{styles:B,shims:Hn}=I,$n={[b]:Object.values(G[b]),[k]:Object.values(G[k]),[O]:Object.values(G[O])};let Gt=null,Ye={},Ue={},Be={},We={},Ge={};const Kn={[b]:Object.keys(W[b]),[k]:Object.keys(W[k]),[O]:Object.keys(W[O])};function Vn(t){return~Tn.indexOf(t)}function qn(t,e){const n=e.split("-"),a=n[0],r=n.slice(1).join("-");return a===t&&r!==""&&!Vn(r)?r:null}const Xe=()=>{const t=a=>xt(B,(r,i,o)=>(r[o]=xt(i,a,{}),r),{});Ye=t((a,r,i)=>(r[3]&&(a[r[3]]=i),r[2]&&r[2].filter(s=>typeof s=="number").forEach(s=>{a[s.toString(16)]=i}),a)),Ue=t((a,r,i)=>(a[i]=i,r[2]&&r[2].filter(s=>typeof s=="string").forEach(s=>{a[s]=i}),a)),Ge=t((a,r,i)=>{const o=r[2];return a[i]=i,o.forEach(s=>{a[s]=i}),a});const e="far"in B||f.autoFetchSvg,n=xt(Hn,(a,r)=>{const i=r[0];let o=r[1];const s=r[2];return o==="far"&&!e&&(o="fas"),typeof i=="string"&&(a.names[i]={prefix:o,iconName:s}),typeof i=="number"&&(a.unicodes[i.toString(16)]={prefix:o,iconName:s}),a},{names:{},unicodes:{}});Be=n.names,We=n.unicodes,Gt=gt(f.styleDefault,{family:f.familyDefault})};Ln(t=>{Gt=gt(t.styleDefault,{family:f.familyDefault})});Xe();function Xt(t,e){return(Ye[t]||{})[e]}function Qn(t,e){return(Ue[t]||{})[e]}function R(t,e){return(Ge[t]||{})[e]}function He(t){return Be[t]||{prefix:null,iconName:null}}function Zn(t){const e=We[t],n=Xt("fas",t);return e||(n?{prefix:"fas",iconName:n}:null)||{prefix:null,iconName:null}}function D(){return Gt}const Ht=()=>({prefix:null,iconName:null,rest:[]});function gt(t){let e=arguments.length>1&&arguments[1]!==void 0?arguments[1]:{};const{family:n=b}=e,a=W[n][t],r=at[n][t]||at[n][a],i=t in I.styles?t:null;return r||i||null}const Jn={[b]:Object.keys(G[b]),[k]:Object.keys(G[k]),[O]:Object.keys(G[O])};function ht(t){let e=arguments.length>1&&arguments[1]!==void 0?arguments[1]:{};const{skipLookups:n=!1}=e,a={[b]:"".concat(f.cssPrefix,"-").concat(b),[k]:"".concat(f.cssPrefix,"-").concat(k),[O]:"".concat(f.cssPrefix,"-").concat(O)};let r=null,i=b;const o=sn.filter(l=>l!==Pe);o.forEach(l=>{(t.includes(a[l])||t.some(c=>Jn[l].includes(c)))&&(i=l)});const s=t.reduce((l,c)=>{const m=qn(f.cssPrefix,c);if(B[c]?(c=$n[i].includes(c)?En[i][c]:c,r=c,l.prefix=c):Kn[i].indexOf(c)>-1?(r=c,l.prefix=gt(c,{family:i})):m?l.iconName=m:c!==f.replacementClass&&!o.some(g=>c===a[g])&&l.rest.push(c),!n&&l.prefix&&l.iconName){const g=r==="fa"?He(l.iconName):{},p=R(l.prefix,l.iconName);g.prefix&&(r=null),l.iconName=g.iconName||p||l.iconName,l.prefix=g.prefix||l.prefix,l.prefix==="far"&&!B.far&&B.fas&&!f.autoFetchSvg&&(l.prefix="fas")}return l},Ht());return(t.includes("fa-brands")||t.includes("fab"))&&(s.prefix="fab"),(t.includes("fa-duotone")||t.includes("fad"))&&(s.prefix="fad"),!s.prefix&&i===k&&(B.fass||f.autoFetchSvg)&&(s.prefix="fass",s.iconName=R(s.prefix,s.iconName)||s.iconName),!s.prefix&&i===O&&(B.fasds||f.autoFetchSvg)&&(s.prefix="fasds",s.iconName=R(s.prefix,s.iconName)||s.iconName),(s.prefix==="fa"||r==="fa")&&(s.prefix=D()||"fas"),s}class ta{constructor(){this.definitions={}}add(){for(var e=arguments.length,n=new Array(e),a=0;a<e;a++)n[a]=arguments[a];const r=n.reduce(this._pullDefinitions,{});Object.keys(r).forEach(i=>{this.definitions[i]={...this.definitions[i]||{},...r[i]},It(i,r[i]);const o=G[b][i];o&&It(o,r[i]),Xe()})}reset(){this.definitions={}}_pullDefinitions(e,n){const a=n.prefix&&n.iconName&&n.icon?{0:n}:n;return Object.keys(a).map(r=>{const{prefix:i,iconName:o,icon:s}=a[r],l=s[2];e[i]||(e[i]={}),l.length>0&&l.forEach(c=>{typeof c=="string"&&(e[i][c]=s)}),e[i][o]=s}),e}}let ie=[],K={};const V={},ea=Object.keys(V);function na(t,e){let{mixoutsTo:n}=e;return ie=t,K={},Object.keys(V).forEach(a=>{ea.indexOf(a)===-1&&delete V[a]}),ie.forEach(a=>{const r=a.mixout?a.mixout():{};if(Object.keys(r).forEach(i=>{typeof r[i]=="function"&&(n[i]=r[i]),typeof r[i]=="object"&&Object.keys(r[i]).forEach(o=>{n[i]||(n[i]={}),n[i][o]=r[i][o]})}),a.hooks){const i=a.hooks();Object.keys(i).forEach(o=>{K[o]||(K[o]=[]),K[o].push(i[o])})}a.provides&&a.provides(V)}),n}function _t(t,e){for(var n=arguments.length,a=new Array(n>2?n-2:0),r=2;r<n;r++)a[r-2]=arguments[r];return(K[t]||[]).forEach(o=>{e=o.apply(null,[e,...a])}),e}function H(t){for(var e=arguments.length,n=new Array(e>1?e-1:0),a=1;a<e;a++)n[a-1]=arguments[a];(K[t]||[]).forEach(i=>{i.apply(null,n)})}function Y(){const t=arguments[0],e=Array.prototype.slice.call(arguments,1);return V[t]?V[t].apply(null,e):void 0}function Tt(t){t.prefix==="fa"&&(t.prefix="fas");let{iconName:e}=t;const n=t.prefix||D();if(e)return e=R(n,e)||e,ae($e.definitions,n,e)||ae(I.styles,n,e)}const $e=new ta,aa=()=>{f.autoReplaceSvg=!1,f.observeMutations=!1,H("noAuto")},ra={i2svg:function(){let t=arguments.length>0&&arguments[0]!==void 0?arguments[0]:{};return L?(H("beforeI2svg",t),Y("pseudoElements2svg",t),Y("i2svg",t)):Promise.reject(new Error("Operation requires a DOM of some kind."))},watch:function(){let t=arguments.length>0&&arguments[0]!==void 0?arguments[0]:{};const{autoReplaceSvgRoot:e}=t;f.autoReplaceSvg===!1&&(f.autoReplaceSvg=!0),f.observeMutations=!0,Wn(()=>{oa({autoReplaceSvgRoot:e}),H("watch",t)})}},ia={icon:t=>{if(t===null)return null;if(typeof t=="object"&&t.prefix&&t.iconName)return{prefix:t.prefix,iconName:R(t.prefix,t.iconName)||t.iconName};if(Array.isArray(t)&&t.length===2){const e=t[1].indexOf("fa-")===0?t[1].slice(3):t[1],n=gt(t[0]);return{prefix:n,iconName:R(n,e)||e}}if(typeof t=="string"&&(t.indexOf("".concat(f.cssPrefix,"-"))>-1||t.match(Cn))){const e=ht(t.split(" "),{skipLookups:!0});return{prefix:e.prefix||D(),iconName:R(e.prefix,e.iconName)||e.iconName}}if(typeof t=="string"){const e=D();return{prefix:e,iconName:R(e,t)||t}}}},S={noAuto:aa,config:f,dom:ra,parse:ia,library:$e,findIconDefinition:Tt,toHtml:ot},oa=function(){let t=arguments.length>0&&arguments[0]!==void 0?arguments[0]:{};const{autoReplaceSvgRoot:e=h}=t;(Object.keys(I.styles).length>0||f.autoFetchSvg)&&L&&f.autoReplaceSvg&&S.dom.i2svg({node:e})};function bt(t,e){return Object.defineProperty(t,"abstract",{get:e}),Object.defineProperty(t,"html",{get:function(){return t.abstract.map(n=>ot(n))}}),Object.defineProperty(t,"node",{get:function(){if(!L)return;const n=h.createElement("div");return n.innerHTML=t.html,n.children}}),t}function sa(t){let{children:e,main:n,mask:a,attributes:r,styles:i,transform:o}=t;if(Wt(o)&&n.found&&!a.found){const{width:s,height:l}=n,c={x:s/l/2,y:.5};r.style=pt({...i,"transform-origin":"".concat(c.x+o.x/16,"em ").concat(c.y+o.y/16,"em")})}return[{tag:"svg",attributes:r,children:e}]}function la(t){let{prefix:e,iconName:n,children:a,attributes:r,symbol:i}=t;const o=i===!0?"".concat(e,"-").concat(f.cssPrefix,"-").concat(n):i;return[{tag:"svg",attributes:{style:"display: none;"},children:[{tag:"symbol",attributes:{...r,id:o},children:a}]}]}function $t(t){const{icons:{main:e,mask:n},prefix:a,iconName:r,transform:i,symbol:o,title:s,maskId:l,titleId:c,extra:m,watchable:g=!1}=t,{width:p,height:v}=n.found?n:e,C=a==="fak",E=[f.replacementClass,r?"".concat(f.cssPrefix,"-").concat(r):""].filter(P=>m.classes.indexOf(P)===-1).filter(P=>P!==""||!!P).concat(m.classes).join(" ");let A={children:[],attributes:{...m.attributes,"data-prefix":a,"data-icon":r,class:E,role:m.attributes.role||"img",xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 ".concat(p," ").concat(v)}};const u=C&&!~m.classes.indexOf("fa-fw")?{width:"".concat(p/v*16*.0625,"em")}:{};g&&(A.attributes[X]=""),s&&(A.children.push({tag:"title",attributes:{id:A.attributes["aria-labelledby"]||"title-".concat(c||rt())},children:[s]}),delete A.attributes.title);const d={...A,prefix:a,iconName:r,main:e,mask:n,maskId:l,transform:i,symbol:o,styles:{...u,...m.styles}},{children:y,attributes:x}=n.found&&e.found?Y("generateAbstractMask",d)||{children:[],attributes:{}}:Y("generateAbstractIcon",d)||{children:[],attributes:{}};return d.children=y,d.attributes=x,o?la(d):sa(d)}function oe(t){const{content:e,width:n,height:a,transform:r,title:i,extra:o,watchable:s=!1}=t,l={...o.attributes,...i?{title:i}:{},class:o.classes.join(" ")};s&&(l[X]="");const c={...o.styles};Wt(r)&&(c.transform=Yn({transform:r,startCentered:!0,width:n,height:a}),c["-webkit-transform"]=c.transform);const m=pt(c);m.length>0&&(l.style=m);const g=[];return g.push({tag:"span",attributes:l,children:[e]}),i&&g.push({tag:"span",attributes:{class:"sr-only"},children:[i]}),g}function ca(t){const{content:e,title:n,extra:a}=t,r={...a.attributes,...n?{title:n}:{},class:a.classes.join(" ")},i=pt(a.styles);i.length>0&&(r.style=i);const o=[];return o.push({tag:"span",attributes:r,children:[e]}),n&&o.push({tag:"span",attributes:{class:"sr-only"},children:[n]}),o}const{styles:At}=I;function Mt(t){const e=t[0],n=t[1],[a]=t.slice(4);let r=null;return Array.isArray(a)?r={tag:"g",attributes:{class:"".concat(f.cssPrefix,"-").concat(yt.GROUP)},children:[{tag:"path",attributes:{class:"".concat(f.cssPrefix,"-").concat(yt.SECONDARY),fill:"currentColor",d:a[0]}},{tag:"path",attributes:{class:"".concat(f.cssPrefix,"-").concat(yt.PRIMARY),fill:"currentColor",d:a[1]}}]}:r={tag:"path",attributes:{fill:"currentColor",d:a}},{found:!0,width:e,height:n,icon:r}}const fa={found:!1,width:512,height:512};function ua(t,e){!_e&&!f.showMissingIcons&&t&&console.error('Icon with name "'.concat(t,'" and prefix "').concat(e,'" is missing.'))}function Ft(t,e){let n=e;return e==="fa"&&f.styleDefault!==null&&(e=D()),new Promise((a,r)=>{if(n==="fa"){const i=He(t)||{};t=i.iconName||t,e=i.prefix||e}if(t&&e&&At[e]&&At[e][t]){const i=At[e][t];return a(Mt(i))}ua(t,e),a({...fa,icon:f.showMissingIcons&&t?Y("missingIconAbstract")||{}:{}})})}const se=()=>{},Lt=f.measurePerformance&&lt&&lt.mark&&lt.measure?lt:{mark:se,measure:se},tt='FA "6.6.0"',ma=t=>(Lt.mark("".concat(tt," ").concat(t," begins")),()=>Ke(t)),Ke=t=>{Lt.mark("".concat(tt," ").concat(t," ends")),Lt.measure("".concat(tt," ").concat(t),"".concat(tt," ").concat(t," begins"),"".concat(tt," ").concat(t," ends"))};var Kt={begin:ma,end:Ke};const ct=()=>{};function le(t){return typeof(t.getAttribute?t.getAttribute(X):null)=="string"}function da(t){const e=t.getAttribute?t.getAttribute(Yt):null,n=t.getAttribute?t.getAttribute(Ut):null;return e&&n}function pa(t){return t&&t.classList&&t.classList.contains&&t.classList.contains(f.replacementClass)}function ga(){return f.autoReplaceSvg===!0?ft.replace:ft[f.autoReplaceSvg]||ft.replace}function ha(t){return h.createElementNS("http://www.w3.org/2000/svg",t)}function ba(t){return h.createElement(t)}function Ve(t){let e=arguments.length>1&&arguments[1]!==void 0?arguments[1]:{};const{ceFn:n=t.tag==="svg"?ha:ba}=e;if(typeof t=="string")return h.createTextNode(t);const a=n(t.tag);return Object.keys(t.attributes||[]).forEach(function(i){a.setAttribute(i,t.attributes[i])}),(t.children||[]).forEach(function(i){a.appendChild(Ve(i,{ceFn:n}))}),a}function ya(t){let e=" ".concat(t.outerHTML," ");return e="".concat(e,"Font Awesome fontawesome.com "),e}const ft={replace:function(t){const e=t[0];if(e.parentNode)if(t[1].forEach(n=>{e.parentNode.insertBefore(Ve(n),e)}),e.getAttribute(X)===null&&f.keepOriginalSource){let n=h.createComment(ya(e));e.parentNode.replaceChild(n,e)}else e.remove()},nest:function(t){const e=t[0],n=t[1];if(~Bt(e).indexOf(f.replacementClass))return ft.replace(t);const a=new RegExp("".concat(f.cssPrefix,"-.*"));if(delete n[0].attributes.id,n[0].attributes.class){const i=n[0].attributes.class.split(" ").reduce((o,s)=>(s===f.replacementClass||s.match(a)?o.toSvg.push(s):o.toNode.push(s),o),{toNode:[],toSvg:[]});n[0].attributes.class=i.toSvg.join(" "),i.toNode.length===0?e.removeAttribute("class"):e.setAttribute("class",i.toNode.join(" "))}const r=n.map(i=>ot(i)).join(`
`);e.setAttribute(X,""),e.innerHTML=r}};function ce(t){t()}function qe(t,e){const n=typeof e=="function"?e:ct;if(t.length===0)n();else{let a=ce;f.mutateApproach===Sn&&(a=j.requestAnimationFrame||ce),a(()=>{const r=ga(),i=Kt.begin("mutate");t.map(r),i(),n()})}}let Vt=!1;function Qe(){Vt=!0}function zt(){Vt=!1}let mt=null;function fe(t){if(!Zt||!f.observeMutations)return;const{treeCallback:e=ct,nodeCallback:n=ct,pseudoElementsCallback:a=ct,observeMutationsRoot:r=h}=t;mt=new Zt(i=>{if(Vt)return;const o=D();Z(i).forEach(s=>{if(s.type==="childList"&&s.addedNodes.length>0&&!le(s.addedNodes[0])&&(f.searchPseudoElements&&a(s.target),e(s.target)),s.type==="attributes"&&s.target.parentNode&&f.searchPseudoElements&&a(s.target.parentNode),s.type==="attributes"&&le(s.target)&&~_n.indexOf(s.attributeName))if(s.attributeName==="class"&&da(s.target)){const{prefix:l,iconName:c}=ht(Bt(s.target));s.target.setAttribute(Yt,l||o),c&&s.target.setAttribute(Ut,c)}else pa(s.target)&&n(s.target)})}),L&&mt.observe(r,{childList:!0,attributes:!0,characterData:!0,subtree:!0})}function va(){mt&&mt.disconnect()}function xa(t){const e=t.getAttribute("style");let n=[];return e&&(n=e.split(";").reduce((a,r)=>{const i=r.split(":"),o=i[0],s=i.slice(1);return o&&s.length>0&&(a[o]=s.join(":").trim()),a},{})),n}function Aa(t){const e=t.getAttribute("data-prefix"),n=t.getAttribute("data-icon"),a=t.innerText!==void 0?t.innerText.trim():"";let r=ht(Bt(t));return r.prefix||(r.prefix=D()),e&&n&&(r.prefix=e,r.iconName=n),r.iconName&&r.prefix||(r.prefix&&a.length>0&&(r.iconName=Qn(r.prefix,t.innerText)||Xt(r.prefix,Nt(t.innerText))),!r.iconName&&f.autoFetchSvg&&t.firstChild&&t.firstChild.nodeType===Node.TEXT_NODE&&(r.iconName=t.firstChild.data)),r}function wa(t){const e=Z(t.attributes).reduce((r,i)=>(r.name!=="class"&&r.name!=="style"&&(r[i.name]=i.value),r),{}),n=t.getAttribute("title"),a=t.getAttribute("data-fa-title-id");return f.autoA11y&&(n?e["aria-labelledby"]="".concat(f.replacementClass,"-title-").concat(a||rt()):(e["aria-hidden"]="true",e.focusable="false")),e}function ka(){return{iconName:null,title:null,titleId:null,prefix:null,transform:N,symbol:!1,mask:{iconName:null,prefix:null,rest:[]},maskId:null,extra:{classes:[],styles:{},attributes:{}}}}function ue(t){let e=arguments.length>1&&arguments[1]!==void 0?arguments[1]:{styleParser:!0};const{iconName:n,prefix:a,rest:r}=Aa(t),i=wa(t),o=_t("parseNodeAttributes",{},t);let s=e.styleParser?xa(t):[];return{iconName:n,title:t.getAttribute("title"),titleId:t.getAttribute("data-fa-title-id"),prefix:a,transform:N,mask:{iconName:null,prefix:null,rest:[]},maskId:null,symbol:!1,extra:{classes:r,styles:s,attributes:i},...o}}const{styles:Oa}=I;function Ze(t){const e=f.autoReplaceSvg==="nest"?ue(t,{styleParser:!1}):ue(t);return~e.extra.classes.indexOf(Fe)?Y("generateLayersText",t,e):Y("generateSvgReplacementMutation",t,e)}let _=new Set;Te.map(t=>{_.add("fa-".concat(t))});Object.keys(W[b]).map(_.add.bind(_));Object.keys(W[k]).map(_.add.bind(_));Object.keys(W[O]).map(_.add.bind(_));_=[..._];function me(t){let e=arguments.length>1&&arguments[1]!==void 0?arguments[1]:null;if(!L)return Promise.resolve();const n=h.documentElement.classList,a=m=>n.add("".concat(ee,"-").concat(m)),r=m=>n.remove("".concat(ee,"-").concat(m)),i=f.autoFetchSvg?_:Te.map(m=>"fa-".concat(m)).concat(Object.keys(Oa));i.includes("fa")||i.push("fa");const o=[".".concat(Fe,":not([").concat(X,"])")].concat(i.map(m=>".".concat(m,":not([").concat(X,"])"))).join(", ");if(o.length===0)return Promise.resolve();let s=[];try{s=Z(t.querySelectorAll(o))}catch{}if(s.length>0)a("pending"),r("complete");else return Promise.resolve();const l=Kt.begin("onTree"),c=s.reduce((m,g)=>{try{const p=Ze(g);p&&m.push(p)}catch(p){_e||p.name==="MissingIcon"&&console.error(p)}return m},[]);return new Promise((m,g)=>{Promise.all(c).then(p=>{qe(p,()=>{a("active"),a("complete"),r("pending"),typeof e=="function"&&e(),l(),m()})}).catch(p=>{l(),g(p)})})}function Sa(t){let e=arguments.length>1&&arguments[1]!==void 0?arguments[1]:null;Ze(t).then(n=>{n&&qe([n],e)})}function Pa(t){return function(e){let n=arguments.length>1&&arguments[1]!==void 0?arguments[1]:{};const a=(e||{}).icon?e:Tt(e||{});let{mask:r}=n;return r&&(r=(r||{}).icon?r:Tt(r||{})),t(a,{...n,mask:r})}}const Ea=function(t){let e=arguments.length>1&&arguments[1]!==void 0?arguments[1]:{};const{transform:n=N,symbol:a=!1,mask:r=null,maskId:i=null,title:o=null,titleId:s=null,classes:l=[],attributes:c={},styles:m={}}=e;if(!t)return;const{prefix:g,iconName:p,icon:v}=t;return bt({type:"icon",...t},()=>(H("beforeDOMElementCreation",{iconDefinition:t,params:e}),f.autoA11y&&(o?c["aria-labelledby"]="".concat(f.replacementClass,"-title-").concat(s||rt()):(c["aria-hidden"]="true",c.focusable="false")),$t({icons:{main:Mt(v),mask:r?Mt(r.icon):{found:!1,width:null,height:null,icon:{}}},prefix:g,iconName:p,transform:{...N,...n},symbol:a,title:o,maskId:i,titleId:s,extra:{attributes:c,styles:m,classes:l}})))};var Ca={mixout(){return{icon:Pa(Ea)}},hooks(){return{mutationObserverCallbacks(t){return t.treeCallback=me,t.nodeCallback=Sa,t}}},provides(t){t.i2svg=function(e){const{node:n=h,callback:a=()=>{}}=e;return me(n,a)},t.generateSvgReplacementMutation=function(e,n){const{iconName:a,title:r,titleId:i,prefix:o,transform:s,symbol:l,mask:c,maskId:m,extra:g}=n;return new Promise((p,v)=>{Promise.all([Ft(a,o),c.iconName?Ft(c.iconName,c.prefix):Promise.resolve({found:!1,width:512,height:512,icon:{}})]).then(C=>{let[E,A]=C;p([e,$t({icons:{main:E,mask:A},prefix:o,iconName:a,transform:s,symbol:l,maskId:m,title:r,titleId:i,extra:g,watchable:!0})])}).catch(v)})},t.generateAbstractIcon=function(e){let{children:n,attributes:a,main:r,transform:i,styles:o}=e;const s=pt(o);s.length>0&&(a.style=s);let l;return Wt(i)&&(l=Y("generateAbstractTransformGrouping",{main:r,transform:i,containerWidth:r.width,iconWidth:r.width})),n.push(l||r.icon),{children:n,attributes:a}}}},Na={mixout(){return{layer(t){let e=arguments.length>1&&arguments[1]!==void 0?arguments[1]:{};const{classes:n=[]}=e;return bt({type:"layer"},()=>{H("beforeDOMElementCreation",{assembler:t,params:e});let a=[];return t(r=>{Array.isArray(r)?r.map(i=>{a=a.concat(i.abstract)}):a=a.concat(r.abstract)}),[{tag:"span",attributes:{class:["".concat(f.cssPrefix,"-layers"),...n].join(" ")},children:a}]})}}}},Ia={mixout(){return{counter(t){let e=arguments.length>1&&arguments[1]!==void 0?arguments[1]:{};const{title:n=null,classes:a=[],attributes:r={},styles:i={}}=e;return bt({type:"counter",content:t},()=>(H("beforeDOMElementCreation",{content:t,params:e}),ca({content:t.toString(),title:n,extra:{attributes:r,styles:i,classes:["".concat(f.cssPrefix,"-layers-counter"),...a]}})))}}}},_a={mixout(){return{text(t){let e=arguments.length>1&&arguments[1]!==void 0?arguments[1]:{};const{transform:n=N,title:a=null,classes:r=[],attributes:i={},styles:o={}}=e;return bt({type:"text",content:t},()=>(H("beforeDOMElementCreation",{content:t,params:e}),oe({content:t,transform:{...N,...n},title:a,extra:{attributes:i,styles:o,classes:["".concat(f.cssPrefix,"-layers-text"),...r]}})))}}},provides(t){t.generateLayersText=function(e,n){const{title:a,transform:r,extra:i}=n;let o=null,s=null;if(Se){const l=parseInt(getComputedStyle(e).fontSize,10),c=e.getBoundingClientRect();o=c.width/l,s=c.height/l}return f.autoA11y&&!a&&(i.attributes["aria-hidden"]="true"),Promise.resolve([e,oe({content:e.innerHTML,width:o,height:s,transform:r,title:a,extra:i,watchable:!0})])}}};const Ta=new RegExp('"',"ug"),de=[1105920,1112319],pe={FontAwesome:{normal:"fas",400:"fas"},...dn,...mn,...An},Rt=Object.keys(pe).reduce((t,e)=>(t[e.toLowerCase()]=pe[e],t),{}),Ma=Object.keys(Rt).reduce((t,e)=>{const n=Rt[e];return t[e]=n[900]||[...Object.entries(n)][0][1],t},{});function Fa(t){const e=t.replace(Ta,""),n=Xn(e,0),a=n>=de[0]&&n<=de[1],r=e.length===2?e[0]===e[1]:!1;return{value:Nt(r?e[0]:e),isSecondary:a||r}}function La(t,e){const n=t.replace(/^['"]|['"]$/g,"").toLowerCase(),a=parseInt(e),r=isNaN(a)?"normal":a;return(Rt[n]||{})[r]||Ma[n]}function ge(t,e){const n="".concat(On).concat(e.replace(":","-"));return new Promise((a,r)=>{if(t.getAttribute(n)!==null)return a();const o=Z(t.children).filter(p=>p.getAttribute(St)===e)[0],s=j.getComputedStyle(t,e),l=s.getPropertyValue("font-family"),c=l.match(Nn),m=s.getPropertyValue("font-weight"),g=s.getPropertyValue("content");if(o&&!c)return t.removeChild(o),a();if(c&&g!=="none"&&g!==""){const p=s.getPropertyValue("content");let v=La(l,m);const{value:C,isSecondary:E}=Fa(p),A=c[0].startsWith("FontAwesome");let u=Xt(v,C),d=u;if(A){const y=Zn(C);y.iconName&&y.prefix&&(u=y.iconName,v=y.prefix)}if(u&&!E&&(!o||o.getAttribute(Yt)!==v||o.getAttribute(Ut)!==d)){t.setAttribute(n,d),o&&t.removeChild(o);const y=ka(),{extra:x}=y;x.attributes[St]=e,Ft(u,v).then(P=>{const st=$t({...y,icons:{main:P,mask:Ht()},prefix:v,iconName:d,extra:x,watchable:!0}),U=h.createElementNS("http://www.w3.org/2000/svg","svg");e==="::before"?t.insertBefore(U,t.firstChild):t.appendChild(U),U.outerHTML=st.map(nn=>ot(nn)).join(`
`),t.removeAttribute(n),a()}).catch(r)}else a()}else a()})}function za(t){return Promise.all([ge(t,"::before"),ge(t,"::after")])}function Ra(t){return t.parentNode!==document.head&&!~Pn.indexOf(t.tagName.toUpperCase())&&!t.getAttribute(St)&&(!t.parentNode||t.parentNode.tagName!=="svg")}function he(t){if(L)return new Promise((e,n)=>{const a=Z(t.querySelectorAll("*")).filter(Ra).map(za),r=Kt.begin("searchPseudoElements");Qe(),Promise.all(a).then(()=>{r(),zt(),e()}).catch(()=>{r(),zt(),n()})})}var ja={hooks(){return{mutationObserverCallbacks(t){return t.pseudoElementsCallback=he,t}}},provides(t){t.pseudoElements2svg=function(e){const{node:n=h}=e;f.searchPseudoElements&&he(n)}}};let be=!1;var Da={mixout(){return{dom:{unwatch(){Qe(),be=!0}}}},hooks(){return{bootstrap(){fe(_t("mutationObserverCallbacks",{}))},noAuto(){va()},watch(t){const{observeMutationsRoot:e}=t;be?zt():fe(_t("mutationObserverCallbacks",{observeMutationsRoot:e}))}}}};const ye=t=>{let e={size:16,x:0,y:0,flipX:!1,flipY:!1,rotate:0};return t.toLowerCase().split(" ").reduce((n,a)=>{const r=a.toLowerCase().split("-"),i=r[0];let o=r.slice(1).join("-");if(i&&o==="h")return n.flipX=!0,n;if(i&&o==="v")return n.flipY=!0,n;if(o=parseFloat(o),isNaN(o))return n;switch(i){case"grow":n.size=n.size+o;break;case"shrink":n.size=n.size-o;break;case"left":n.x=n.x-o;break;case"right":n.x=n.x+o;break;case"up":n.y=n.y-o;break;case"down":n.y=n.y+o;break;case"rotate":n.rotate=n.rotate+o;break}return n},e)};var Ya={mixout(){return{parse:{transform:t=>ye(t)}}},hooks(){return{parseNodeAttributes(t,e){const n=e.getAttribute("data-fa-transform");return n&&(t.transform=ye(n)),t}}},provides(t){t.generateAbstractTransformGrouping=function(e){let{main:n,transform:a,containerWidth:r,iconWidth:i}=e;const o={transform:"translate(".concat(r/2," 256)")},s="translate(".concat(a.x*32,", ").concat(a.y*32,") "),l="scale(".concat(a.size/16*(a.flipX?-1:1),", ").concat(a.size/16*(a.flipY?-1:1),") "),c="rotate(".concat(a.rotate," 0 0)"),m={transform:"".concat(s," ").concat(l," ").concat(c)},g={transform:"translate(".concat(i/2*-1," -256)")},p={outer:o,inner:m,path:g};return{tag:"g",attributes:{...p.outer},children:[{tag:"g",attributes:{...p.inner},children:[{tag:n.icon.tag,children:n.icon.children,attributes:{...n.icon.attributes,...p.path}}]}]}}}};const wt={x:0,y:0,width:"100%",height:"100%"};function ve(t){let e=arguments.length>1&&arguments[1]!==void 0?arguments[1]:!0;return t.attributes&&(t.attributes.fill||e)&&(t.attributes.fill="black"),t}function Ua(t){return t.tag==="g"?t.children:[t]}var Ba={hooks(){return{parseNodeAttributes(t,e){const n=e.getAttribute("data-fa-mask"),a=n?ht(n.split(" ").map(r=>r.trim())):Ht();return a.prefix||(a.prefix=D()),t.mask=a,t.maskId=e.getAttribute("data-fa-mask-id"),t}}},provides(t){t.generateAbstractMask=function(e){let{children:n,attributes:a,main:r,mask:i,maskId:o,transform:s}=e;const{width:l,icon:c}=r,{width:m,icon:g}=i,p=Dn({transform:s,containerWidth:m,iconWidth:l}),v={tag:"rect",attributes:{...wt,fill:"white"}},C=c.children?{children:c.children.map(ve)}:{},E={tag:"g",attributes:{...p.inner},children:[ve({tag:c.tag,attributes:{...c.attributes,...p.path},...C})]},A={tag:"g",attributes:{...p.outer},children:[E]},u="mask-".concat(o||rt()),d="clip-".concat(o||rt()),y={tag:"mask",attributes:{...wt,id:u,maskUnits:"userSpaceOnUse",maskContentUnits:"userSpaceOnUse"},children:[v,A]},x={tag:"defs",children:[{tag:"clipPath",attributes:{id:d},children:Ua(g)},y]};return n.push(x,{tag:"rect",attributes:{fill:"currentColor","clip-path":"url(#".concat(d,")"),mask:"url(#".concat(u,")"),...wt}}),{children:n,attributes:a}}}},Wa={provides(t){let e=!1;j.matchMedia&&(e=j.matchMedia("(prefers-reduced-motion: reduce)").matches),t.missingIconAbstract=function(){const n=[],a={fill:"currentColor"},r={attributeType:"XML",repeatCount:"indefinite",dur:"2s"};n.push({tag:"path",attributes:{...a,d:"M156.5,447.7l-12.6,29.5c-18.7-9.5-35.9-21.2-51.5-34.9l22.7-22.7C127.6,430.5,141.5,440,156.5,447.7z M40.6,272H8.5 c1.4,21.2,5.4,41.7,11.7,61.1L50,321.2C45.1,305.5,41.8,289,40.6,272z M40.6,240c1.4-18.8,5.2-37,11.1-54.1l-29.5-12.6 C14.7,194.3,10,216.7,8.5,240H40.6z M64.3,156.5c7.8-14.9,17.2-28.8,28.1-41.5L69.7,92.3c-13.7,15.6-25.5,32.8-34.9,51.5 L64.3,156.5z M397,419.6c-13.9,12-29.4,22.3-46.1,30.4l11.9,29.8c20.7-9.9,39.8-22.6,56.9-37.6L397,419.6z M115,92.4 c13.9-12,29.4-22.3,46.1-30.4l-11.9-29.8c-20.7,9.9-39.8,22.6-56.8,37.6L115,92.4z M447.7,355.5c-7.8,14.9-17.2,28.8-28.1,41.5 l22.7,22.7c13.7-15.6,25.5-32.9,34.9-51.5L447.7,355.5z M471.4,272c-1.4,18.8-5.2,37-11.1,54.1l29.5,12.6 c7.5-21.1,12.2-43.5,13.6-66.8H471.4z M321.2,462c-15.7,5-32.2,8.2-49.2,9.4v32.1c21.2-1.4,41.7-5.4,61.1-11.7L321.2,462z M240,471.4c-18.8-1.4-37-5.2-54.1-11.1l-12.6,29.5c21.1,7.5,43.5,12.2,66.8,13.6V471.4z M462,190.8c5,15.7,8.2,32.2,9.4,49.2h32.1 c-1.4-21.2-5.4-41.7-11.7-61.1L462,190.8z M92.4,397c-12-13.9-22.3-29.4-30.4-46.1l-29.8,11.9c9.9,20.7,22.6,39.8,37.6,56.9 L92.4,397z M272,40.6c18.8,1.4,36.9,5.2,54.1,11.1l12.6-29.5C317.7,14.7,295.3,10,272,8.5V40.6z M190.8,50 c15.7-5,32.2-8.2,49.2-9.4V8.5c-21.2,1.4-41.7,5.4-61.1,11.7L190.8,50z M442.3,92.3L419.6,115c12,13.9,22.3,29.4,30.5,46.1 l29.8-11.9C470,128.5,457.3,109.4,442.3,92.3z M397,92.4l22.7-22.7c-15.6-13.7-32.8-25.5-51.5-34.9l-12.6,29.5 C370.4,72.1,384.4,81.5,397,92.4z"}});const i={...r,attributeName:"opacity"},o={tag:"circle",attributes:{...a,cx:"256",cy:"364",r:"28"},children:[]};return e||o.children.push({tag:"animate",attributes:{...r,attributeName:"r",values:"28;14;28;28;14;28;"}},{tag:"animate",attributes:{...i,values:"1;0;1;1;0;1;"}}),n.push(o),n.push({tag:"path",attributes:{...a,opacity:"1",d:"M263.7,312h-16c-6.6,0-12-5.4-12-12c0-71,77.4-63.9,77.4-107.8c0-20-17.8-40.2-57.4-40.2c-29.1,0-44.3,9.6-59.2,28.7 c-3.9,5-11.1,6-16.2,2.4l-13.1-9.2c-5.6-3.9-6.9-11.8-2.6-17.2c21.2-27.2,46.4-44.7,91.2-44.7c52.3,0,97.4,29.8,97.4,80.2 c0,67.6-77.4,63.5-77.4,107.8C275.7,306.6,270.3,312,263.7,312z"},children:e?[]:[{tag:"animate",attributes:{...i,values:"1;0;0;0;0;1;"}}]}),e||n.push({tag:"path",attributes:{...a,opacity:"0",d:"M232.5,134.5l7,168c0.3,6.4,5.6,11.5,12,11.5h9c6.4,0,11.7-5.1,12-11.5l7-168c0.3-6.8-5.2-12.5-12-12.5h-23 C237.7,122,232.2,127.7,232.5,134.5z"},children:[{tag:"animate",attributes:{...i,values:"0;0;1;1;0;0;"}}]}),{tag:"g",attributes:{class:"missing"},children:n}}}},Ga={hooks(){return{parseNodeAttributes(t,e){const n=e.getAttribute("data-fa-symbol"),a=n===null?!1:n===""?!0:n;return t.symbol=a,t}}}},Xa=[Bn,Ca,Na,Ia,_a,ja,Da,Ya,Ba,Wa,Ga];na(Xa,{mixoutsTo:S});S.noAuto;S.config;S.library;S.dom;const jt=S.parse;S.findIconDefinition;S.toHtml;const Ha=S.icon;S.layer;S.text;S.counter;function xe(t,e){var n=Object.keys(t);if(Object.getOwnPropertySymbols){var a=Object.getOwnPropertySymbols(t);e&&(a=a.filter(function(r){return Object.getOwnPropertyDescriptor(t,r).enumerable})),n.push.apply(n,a)}return n}function T(t){for(var e=1;e<arguments.length;e++){var n=arguments[e]!=null?arguments[e]:{};e%2?xe(Object(n),!0).forEach(function(a){w(t,a,n[a])}):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(n)):xe(Object(n)).forEach(function(a){Object.defineProperty(t,a,Object.getOwnPropertyDescriptor(n,a))})}return t}function $a(t,e){if(typeof t!="object"||!t)return t;var n=t[Symbol.toPrimitive];if(n!==void 0){var a=n.call(t,e||"default");if(typeof a!="object")return a;throw new TypeError("@@toPrimitive must return a primitive value.")}return(e==="string"?String:Number)(t)}function Ka(t){var e=$a(t,"string");return typeof e=="symbol"?e:e+""}function dt(t){"@babel/helpers - typeof";return dt=typeof Symbol=="function"&&typeof Symbol.iterator=="symbol"?function(e){return typeof e}:function(e){return e&&typeof Symbol=="function"&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e},dt(t)}function w(t,e,n){return e=Ka(e),e in t?Object.defineProperty(t,e,{value:n,enumerable:!0,configurable:!0,writable:!0}):t[e]=n,t}function Va(t,e){if(t==null)return{};var n={};for(var a in t)if(Object.prototype.hasOwnProperty.call(t,a)){if(e.indexOf(a)>=0)continue;n[a]=t[a]}return n}function qa(t,e){if(t==null)return{};var n=Va(t,e),a,r;if(Object.getOwnPropertySymbols){var i=Object.getOwnPropertySymbols(t);for(r=0;r<i.length;r++)a=i[r],!(e.indexOf(a)>=0)&&Object.prototype.propertyIsEnumerable.call(t,a)&&(n[a]=t[a])}return n}var Qa=typeof globalThis<"u"?globalThis:typeof window<"u"?window:typeof global<"u"?global:typeof self<"u"?self:{},Je={exports:{}};(function(t){(function(e){var n=function(u,d,y){if(!c(d)||g(d)||p(d)||v(d)||l(d))return d;var x,P=0,st=0;if(m(d))for(x=[],st=d.length;P<st;P++)x.push(n(u,d[P],y));else{x={};for(var U in d)Object.prototype.hasOwnProperty.call(d,U)&&(x[u(U,y)]=n(u,d[U],y))}return x},a=function(u,d){d=d||{};var y=d.separator||"_",x=d.split||/(?=[A-Z])/;return u.split(x).join(y)},r=function(u){return C(u)?u:(u=u.replace(/[\-_\s]+(.)?/g,function(d,y){return y?y.toUpperCase():""}),u.substr(0,1).toLowerCase()+u.substr(1))},i=function(u){var d=r(u);return d.substr(0,1).toUpperCase()+d.substr(1)},o=function(u,d){return a(u,d).toLowerCase()},s=Object.prototype.toString,l=function(u){return typeof u=="function"},c=function(u){return u===Object(u)},m=function(u){return s.call(u)=="[object Array]"},g=function(u){return s.call(u)=="[object Date]"},p=function(u){return s.call(u)=="[object RegExp]"},v=function(u){return s.call(u)=="[object Boolean]"},C=function(u){return u=u-0,u===u},E=function(u,d){var y=d&&"process"in d?d.process:d;return typeof y!="function"?u:function(x,P){return y(x,u,P)}},A={camelize:r,decamelize:o,pascalize:i,depascalize:o,camelizeKeys:function(u,d){return n(E(r,d),u)},decamelizeKeys:function(u,d){return n(E(o,d),u,d)},pascalizeKeys:function(u,d){return n(E(i,d),u)},depascalizeKeys:function(){return this.decamelizeKeys.apply(this,arguments)}};t.exports?t.exports=A:e.humps=A})(Qa)})(Je);var Za=Je.exports,Ja=["class","style"];function tr(t){return t.split(";").map(function(e){return e.trim()}).filter(function(e){return e}).reduce(function(e,n){var a=n.indexOf(":"),r=Za.camelize(n.slice(0,a)),i=n.slice(a+1).trim();return e[r]=i,e},{})}function er(t){return t.split(/\s+/).reduce(function(e,n){return e[n]=!0,e},{})}function tn(t){var e=arguments.length>1&&arguments[1]!==void 0?arguments[1]:{},n=arguments.length>2&&arguments[2]!==void 0?arguments[2]:{};if(typeof t=="string")return t;var a=(t.children||[]).map(function(l){return tn(l)}),r=Object.keys(t.attributes||{}).reduce(function(l,c){var m=t.attributes[c];switch(c){case"class":l.class=er(m);break;case"style":l.style=tr(m);break;default:l.attrs[c]=m}return l},{attrs:{},class:{},style:{}});n.class;var i=n.style,o=i===void 0?{}:i,s=qa(n,Ja);return on(t.tag,T(T(T({},e),{},{class:r.class,style:T(T({},r.style),o)},r.attrs),s),a)}var en=!1;try{en=!0}catch{}function nr(){if(!en&&console&&typeof console.error=="function"){var t;(t=console).error.apply(t,arguments)}}function kt(t,e){return Array.isArray(e)&&e.length>0||!Array.isArray(e)&&e?w({},t,e):{}}function ar(t){var e,n=(e={"fa-spin":t.spin,"fa-pulse":t.pulse,"fa-fw":t.fixedWidth,"fa-border":t.border,"fa-li":t.listItem,"fa-inverse":t.inverse,"fa-flip":t.flip===!0,"fa-flip-horizontal":t.flip==="horizontal"||t.flip==="both","fa-flip-vertical":t.flip==="vertical"||t.flip==="both"},w(w(w(w(w(w(w(w(w(w(e,"fa-".concat(t.size),t.size!==null),"fa-rotate-".concat(t.rotation),t.rotation!==null),"fa-pull-".concat(t.pull),t.pull!==null),"fa-swap-opacity",t.swapOpacity),"fa-bounce",t.bounce),"fa-shake",t.shake),"fa-beat",t.beat),"fa-fade",t.fade),"fa-beat-fade",t.beatFade),"fa-flash",t.flash),w(w(e,"fa-spin-pulse",t.spinPulse),"fa-spin-reverse",t.spinReverse));return Object.keys(n).map(function(a){return n[a]?a:null}).filter(function(a){return a})}function Ae(t){if(t&&dt(t)==="object"&&t.prefix&&t.iconName&&t.icon)return t;if(jt.icon)return jt.icon(t);if(t===null)return null;if(dt(t)==="object"&&t.prefix&&t.iconName)return t;if(Array.isArray(t)&&t.length===2)return{prefix:t[0],iconName:t[1]};if(typeof t=="string")return{prefix:"fas",iconName:t}}var ir=an({name:"FontAwesomeIcon",props:{border:{type:Boolean,default:!1},fixedWidth:{type:Boolean,default:!1},flip:{type:[Boolean,String],default:!1,validator:function(e){return[!0,!1,"horizontal","vertical","both"].indexOf(e)>-1}},icon:{type:[Object,Array,String],required:!0},mask:{type:[Object,Array,String],default:null},maskId:{type:String,default:null},listItem:{type:Boolean,default:!1},pull:{type:String,default:null,validator:function(e){return["right","left"].indexOf(e)>-1}},pulse:{type:Boolean,default:!1},rotation:{type:[String,Number],default:null,validator:function(e){return[90,180,270].indexOf(Number.parseInt(e,10))>-1}},swapOpacity:{type:Boolean,default:!1},size:{type:String,default:null,validator:function(e){return["2xs","xs","sm","lg","xl","2xl","1x","2x","3x","4x","5x","6x","7x","8x","9x","10x"].indexOf(e)>-1}},spin:{type:Boolean,default:!1},transform:{type:[String,Object],default:null},symbol:{type:[Boolean,String],default:!1},title:{type:String,default:null},titleId:{type:String,default:null},inverse:{type:Boolean,default:!1},bounce:{type:Boolean,default:!1},shake:{type:Boolean,default:!1},beat:{type:Boolean,default:!1},fade:{type:Boolean,default:!1},beatFade:{type:Boolean,default:!1},flash:{type:Boolean,default:!1},spinPulse:{type:Boolean,default:!1},spinReverse:{type:Boolean,default:!1}},setup:function(e,n){var a=n.attrs,r=$(function(){return Ae(e.icon)}),i=$(function(){return kt("classes",ar(e))}),o=$(function(){return kt("transform",typeof e.transform=="string"?jt.transform(e.transform):e.transform)}),s=$(function(){return kt("mask",Ae(e.mask))}),l=$(function(){return Ha(r.value,T(T(T(T({},i.value),o.value),s.value),{},{symbol:e.symbol,title:e.title,titleId:e.titleId,maskId:e.maskId}))});rn(l,function(m){if(!m)return nr("Could not find one or more icon(s)",r.value,s.value)},{immediate:!0});var c=$(function(){return l.value?tn(l.value.abstract[0],{},a):null});return function(){return c.value}}});const or={prefix:"fas",iconName:"eye-slash",icon:[640,512,[],"f070","M38.8 5.1C28.4-3.1 13.3-1.2 5.1 9.2S-1.2 34.7 9.2 42.9l592 464c10.4 8.2 25.5 6.3 33.7-4.1s6.3-25.5-4.1-33.7L525.6 386.7c39.6-40.6 66.4-86.1 79.9-118.4c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C465.5 68.8 400.8 32 320 32c-68.2 0-125 26.3-169.3 60.8L38.8 5.1zM223.1 149.5C248.6 126.2 282.7 112 320 112c79.5 0 144 64.5 144 144c0 24.9-6.3 48.3-17.4 68.7L408 294.5c8.4-19.3 10.6-41.4 4.8-63.3c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3c0 10.2-2.4 19.8-6.6 28.3l-90.3-70.8zM373 389.9c-16.4 6.5-34.3 10.1-53 10.1c-79.5 0-144-64.5-144-144c0-6.9 .5-13.6 1.4-20.2L83.1 161.5C60.3 191.2 44 220.8 34.5 243.7c-3.3 7.9-3.3 16.7 0 24.6c14.9 35.7 46.2 87.7 93 131.1C174.5 443.2 239.2 480 320 480c47.8 0 89.9-12.9 126.2-32.5L373 389.9z"]},sr={prefix:"fas",iconName:"chevron-up",icon:[512,512,[],"f077","M233.4 105.4c12.5-12.5 32.8-12.5 45.3 0l192 192c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L256 173.3 86.6 342.6c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3l192-192z"]},lr={prefix:"fas",iconName:"eye",icon:[576,512,[128065],"f06e","M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"]},cr={prefix:"fas",iconName:"chevron-down",icon:[512,512,[],"f078","M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z"]};export{ir as F,lr as a,sr as b,cr as c,or as f};
