var l="Function.prototype.bind called on incompatible ",y=Object.prototype.toString,g=Math.max,h="[object Function]",v=function(o,t){for(var n=[],r=0;r<o.length;r+=1)n[r]=o[r];for(var e=0;e<t.length;e+=1)n[e+o.length]=t[e];return n},s=function(o,t){for(var n=[],r=t,e=0;r<o.length;r+=1,e+=1)n[e]=o[r];return n},b=function(a,o){for(var t="",n=0;n<a.length;n+=1)t+=a[n],n+1<a.length&&(t+=o);return t},d=function(o){var t=this;if(typeof t!="function"||y.apply(t)!==h)throw new TypeError(l+t);for(var n=s(arguments,1),r,e=function(){if(this instanceof r){var i=t.apply(this,v(n,arguments));return Object(i)===i?i:this}return t.apply(o,v(n,arguments))},f=g(0,t.length-n.length),c=[],p=0;p<f;p++)c[p]="$"+p;if(r=Function("binder","return function ("+b(c,",")+"){ return binder.apply(this,arguments); }")(e),t.prototype){var u=function(){};u.prototype=t.prototype,r.prototype=new u,u.prototype=null}return r},m=d,F=Function.prototype.bind||m;export{F as f};
