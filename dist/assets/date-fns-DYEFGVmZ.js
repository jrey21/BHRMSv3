import{b as X}from"./@babel-DnfDSJcD.js";function O(a){if(a===null||a===!0||a===!1)return NaN;var e=Number(a);return isNaN(e)?e:e<0?Math.ceil(e):Math.floor(e)}function h(a,e){if(e.length<a)throw new TypeError(a+" argument"+(a>1?"s":"")+" required, but only "+e.length+" present")}function b(a){h(1,arguments);var e=Object.prototype.toString.call(a);return a instanceof Date||X(a)==="object"&&e==="[object Date]"?new Date(a.getTime()):typeof a=="number"||e==="[object Number]"?new Date(a):((typeof a=="string"||e==="[object String]")&&typeof console<"u"&&(console.warn("Starting with v2.0.0-beta.1 date-fns doesn't accept strings as date arguments. Please use `parseISO` to parse strings. See: https://github.com/date-fns/date-fns/blob/master/docs/upgradeGuide.md#string-arguments"),console.warn(new Error().stack)),new Date(NaN))}function K(a,e){h(2,arguments);var t=b(a).getTime(),r=O(e);return new Date(t+r)}var z={};function _(){return z}function Z(a){var e=new Date(Date.UTC(a.getFullYear(),a.getMonth(),a.getDate(),a.getHours(),a.getMinutes(),a.getSeconds(),a.getMilliseconds()));return e.setUTCFullYear(a.getFullYear()),a.getTime()-e.getTime()}function ee(a){return h(1,arguments),a instanceof Date||X(a)==="object"&&Object.prototype.toString.call(a)==="[object Date]"}function te(a){if(h(1,arguments),!ee(a)&&typeof a!="number")return!1;var e=b(a);return!isNaN(Number(e))}function re(a,e){h(2,arguments);var t=O(e);return K(a,-t)}var ae=864e5;function ne(a){h(1,arguments);var e=b(a),t=e.getTime();e.setUTCMonth(0,1),e.setUTCHours(0,0,0,0);var r=e.getTime(),n=t-r;return Math.floor(n/ae)+1}function Y(a){h(1,arguments);var e=1,t=b(a),r=t.getUTCDay(),n=(r<e?7:0)+r-e;return t.setUTCDate(t.getUTCDate()-n),t.setUTCHours(0,0,0,0),t}function G(a){h(1,arguments);var e=b(a),t=e.getUTCFullYear(),r=new Date(0);r.setUTCFullYear(t+1,0,4),r.setUTCHours(0,0,0,0);var n=Y(r),i=new Date(0);i.setUTCFullYear(t,0,4),i.setUTCHours(0,0,0,0);var o=Y(i);return e.getTime()>=n.getTime()?t+1:e.getTime()>=o.getTime()?t:t-1}function ie(a){h(1,arguments);var e=G(a),t=new Date(0);t.setUTCFullYear(e,0,4),t.setUTCHours(0,0,0,0);var r=Y(t);return r}var oe=6048e5;function ue(a){h(1,arguments);var e=b(a),t=Y(e).getTime()-ie(e).getTime();return Math.round(t/oe)+1}function E(a,e){var t,r,n,i,o,s,l,d;h(1,arguments);var f=_(),c=O((t=(r=(n=(i=e==null?void 0:e.weekStartsOn)!==null&&i!==void 0?i:e==null||(o=e.locale)===null||o===void 0||(s=o.options)===null||s===void 0?void 0:s.weekStartsOn)!==null&&n!==void 0?n:f.weekStartsOn)!==null&&r!==void 0?r:(l=f.locale)===null||l===void 0||(d=l.options)===null||d===void 0?void 0:d.weekStartsOn)!==null&&t!==void 0?t:0);if(!(c>=0&&c<=6))throw new RangeError("weekStartsOn must be between 0 and 6 inclusively");var v=b(a),m=v.getUTCDay(),w=(m<c?7:0)+m-c;return v.setUTCDate(v.getUTCDate()-w),v.setUTCHours(0,0,0,0),v}function I(a,e){var t,r,n,i,o,s,l,d;h(1,arguments);var f=b(a),c=f.getUTCFullYear(),v=_(),m=O((t=(r=(n=(i=e==null?void 0:e.firstWeekContainsDate)!==null&&i!==void 0?i:e==null||(o=e.locale)===null||o===void 0||(s=o.options)===null||s===void 0?void 0:s.firstWeekContainsDate)!==null&&n!==void 0?n:v.firstWeekContainsDate)!==null&&r!==void 0?r:(l=v.locale)===null||l===void 0||(d=l.options)===null||d===void 0?void 0:d.firstWeekContainsDate)!==null&&t!==void 0?t:1);if(!(m>=1&&m<=7))throw new RangeError("firstWeekContainsDate must be between 1 and 7 inclusively");var w=new Date(0);w.setUTCFullYear(c+1,0,m),w.setUTCHours(0,0,0,0);var D=E(w,e),T=new Date(0);T.setUTCFullYear(c,0,m),T.setUTCHours(0,0,0,0);var N=E(T,e);return f.getTime()>=D.getTime()?c+1:f.getTime()>=N.getTime()?c:c-1}function se(a,e){var t,r,n,i,o,s,l,d;h(1,arguments);var f=_(),c=O((t=(r=(n=(i=e==null?void 0:e.firstWeekContainsDate)!==null&&i!==void 0?i:e==null||(o=e.locale)===null||o===void 0||(s=o.options)===null||s===void 0?void 0:s.firstWeekContainsDate)!==null&&n!==void 0?n:f.firstWeekContainsDate)!==null&&r!==void 0?r:(l=f.locale)===null||l===void 0||(d=l.options)===null||d===void 0?void 0:d.firstWeekContainsDate)!==null&&t!==void 0?t:1),v=I(a,e),m=new Date(0);m.setUTCFullYear(v,0,c),m.setUTCHours(0,0,0,0);var w=E(m,e);return w}var de=6048e5;function le(a,e){h(1,arguments);var t=b(a),r=E(t,e).getTime()-se(t,e).getTime();return Math.round(r/de)+1}function u(a,e){for(var t=a<0?"-":"",r=Math.abs(a).toString();r.length<e;)r="0"+r;return t+r}var p={y:function(e,t){var r=e.getUTCFullYear(),n=r>0?r:1-r;return u(t==="yy"?n%100:n,t.length)},M:function(e,t){var r=e.getUTCMonth();return t==="M"?String(r+1):u(r+1,2)},d:function(e,t){return u(e.getUTCDate(),t.length)},a:function(e,t){var r=e.getUTCHours()/12>=1?"pm":"am";switch(t){case"a":case"aa":return r.toUpperCase();case"aaa":return r;case"aaaaa":return r[0];case"aaaa":default:return r==="am"?"a.m.":"p.m."}},h:function(e,t){return u(e.getUTCHours()%12||12,t.length)},H:function(e,t){return u(e.getUTCHours(),t.length)},m:function(e,t){return u(e.getUTCMinutes(),t.length)},s:function(e,t){return u(e.getUTCSeconds(),t.length)},S:function(e,t){var r=t.length,n=e.getUTCMilliseconds(),i=Math.floor(n*Math.pow(10,r-3));return u(i,t.length)}},M={am:"am",pm:"pm",midnight:"midnight",noon:"noon",morning:"morning",afternoon:"afternoon",evening:"evening",night:"night"},ce={G:function(e,t,r){var n=e.getUTCFullYear()>0?1:0;switch(t){case"G":case"GG":case"GGG":return r.era(n,{width:"abbreviated"});case"GGGGG":return r.era(n,{width:"narrow"});case"GGGG":default:return r.era(n,{width:"wide"})}},y:function(e,t,r){if(t==="yo"){var n=e.getUTCFullYear(),i=n>0?n:1-n;return r.ordinalNumber(i,{unit:"year"})}return p.y(e,t)},Y:function(e,t,r,n){var i=I(e,n),o=i>0?i:1-i;if(t==="YY"){var s=o%100;return u(s,2)}return t==="Yo"?r.ordinalNumber(o,{unit:"year"}):u(o,t.length)},R:function(e,t){var r=G(e);return u(r,t.length)},u:function(e,t){var r=e.getUTCFullYear();return u(r,t.length)},Q:function(e,t,r){var n=Math.ceil((e.getUTCMonth()+1)/3);switch(t){case"Q":return String(n);case"QQ":return u(n,2);case"Qo":return r.ordinalNumber(n,{unit:"quarter"});case"QQQ":return r.quarter(n,{width:"abbreviated",context:"formatting"});case"QQQQQ":return r.quarter(n,{width:"narrow",context:"formatting"});case"QQQQ":default:return r.quarter(n,{width:"wide",context:"formatting"})}},q:function(e,t,r){var n=Math.ceil((e.getUTCMonth()+1)/3);switch(t){case"q":return String(n);case"qq":return u(n,2);case"qo":return r.ordinalNumber(n,{unit:"quarter"});case"qqq":return r.quarter(n,{width:"abbreviated",context:"standalone"});case"qqqqq":return r.quarter(n,{width:"narrow",context:"standalone"});case"qqqq":default:return r.quarter(n,{width:"wide",context:"standalone"})}},M:function(e,t,r){var n=e.getUTCMonth();switch(t){case"M":case"MM":return p.M(e,t);case"Mo":return r.ordinalNumber(n+1,{unit:"month"});case"MMM":return r.month(n,{width:"abbreviated",context:"formatting"});case"MMMMM":return r.month(n,{width:"narrow",context:"formatting"});case"MMMM":default:return r.month(n,{width:"wide",context:"formatting"})}},L:function(e,t,r){var n=e.getUTCMonth();switch(t){case"L":return String(n+1);case"LL":return u(n+1,2);case"Lo":return r.ordinalNumber(n+1,{unit:"month"});case"LLL":return r.month(n,{width:"abbreviated",context:"standalone"});case"LLLLL":return r.month(n,{width:"narrow",context:"standalone"});case"LLLL":default:return r.month(n,{width:"wide",context:"standalone"})}},w:function(e,t,r,n){var i=le(e,n);return t==="wo"?r.ordinalNumber(i,{unit:"week"}):u(i,t.length)},I:function(e,t,r){var n=ue(e);return t==="Io"?r.ordinalNumber(n,{unit:"week"}):u(n,t.length)},d:function(e,t,r){return t==="do"?r.ordinalNumber(e.getUTCDate(),{unit:"date"}):p.d(e,t)},D:function(e,t,r){var n=ne(e);return t==="Do"?r.ordinalNumber(n,{unit:"dayOfYear"}):u(n,t.length)},E:function(e,t,r){var n=e.getUTCDay();switch(t){case"E":case"EE":case"EEE":return r.day(n,{width:"abbreviated",context:"formatting"});case"EEEEE":return r.day(n,{width:"narrow",context:"formatting"});case"EEEEEE":return r.day(n,{width:"short",context:"formatting"});case"EEEE":default:return r.day(n,{width:"wide",context:"formatting"})}},e:function(e,t,r,n){var i=e.getUTCDay(),o=(i-n.weekStartsOn+8)%7||7;switch(t){case"e":return String(o);case"ee":return u(o,2);case"eo":return r.ordinalNumber(o,{unit:"day"});case"eee":return r.day(i,{width:"abbreviated",context:"formatting"});case"eeeee":return r.day(i,{width:"narrow",context:"formatting"});case"eeeeee":return r.day(i,{width:"short",context:"formatting"});case"eeee":default:return r.day(i,{width:"wide",context:"formatting"})}},c:function(e,t,r,n){var i=e.getUTCDay(),o=(i-n.weekStartsOn+8)%7||7;switch(t){case"c":return String(o);case"cc":return u(o,t.length);case"co":return r.ordinalNumber(o,{unit:"day"});case"ccc":return r.day(i,{width:"abbreviated",context:"standalone"});case"ccccc":return r.day(i,{width:"narrow",context:"standalone"});case"cccccc":return r.day(i,{width:"short",context:"standalone"});case"cccc":default:return r.day(i,{width:"wide",context:"standalone"})}},i:function(e,t,r){var n=e.getUTCDay(),i=n===0?7:n;switch(t){case"i":return String(i);case"ii":return u(i,t.length);case"io":return r.ordinalNumber(i,{unit:"day"});case"iii":return r.day(n,{width:"abbreviated",context:"formatting"});case"iiiii":return r.day(n,{width:"narrow",context:"formatting"});case"iiiiii":return r.day(n,{width:"short",context:"formatting"});case"iiii":default:return r.day(n,{width:"wide",context:"formatting"})}},a:function(e,t,r){var n=e.getUTCHours(),i=n/12>=1?"pm":"am";switch(t){case"a":case"aa":return r.dayPeriod(i,{width:"abbreviated",context:"formatting"});case"aaa":return r.dayPeriod(i,{width:"abbreviated",context:"formatting"}).toLowerCase();case"aaaaa":return r.dayPeriod(i,{width:"narrow",context:"formatting"});case"aaaa":default:return r.dayPeriod(i,{width:"wide",context:"formatting"})}},b:function(e,t,r){var n=e.getUTCHours(),i;switch(n===12?i=M.noon:n===0?i=M.midnight:i=n/12>=1?"pm":"am",t){case"b":case"bb":return r.dayPeriod(i,{width:"abbreviated",context:"formatting"});case"bbb":return r.dayPeriod(i,{width:"abbreviated",context:"formatting"}).toLowerCase();case"bbbbb":return r.dayPeriod(i,{width:"narrow",context:"formatting"});case"bbbb":default:return r.dayPeriod(i,{width:"wide",context:"formatting"})}},B:function(e,t,r){var n=e.getUTCHours(),i;switch(n>=17?i=M.evening:n>=12?i=M.afternoon:n>=4?i=M.morning:i=M.night,t){case"B":case"BB":case"BBB":return r.dayPeriod(i,{width:"abbreviated",context:"formatting"});case"BBBBB":return r.dayPeriod(i,{width:"narrow",context:"formatting"});case"BBBB":default:return r.dayPeriod(i,{width:"wide",context:"formatting"})}},h:function(e,t,r){if(t==="ho"){var n=e.getUTCHours()%12;return n===0&&(n=12),r.ordinalNumber(n,{unit:"hour"})}return p.h(e,t)},H:function(e,t,r){return t==="Ho"?r.ordinalNumber(e.getUTCHours(),{unit:"hour"}):p.H(e,t)},K:function(e,t,r){var n=e.getUTCHours()%12;return t==="Ko"?r.ordinalNumber(n,{unit:"hour"}):u(n,t.length)},k:function(e,t,r){var n=e.getUTCHours();return n===0&&(n=24),t==="ko"?r.ordinalNumber(n,{unit:"hour"}):u(n,t.length)},m:function(e,t,r){return t==="mo"?r.ordinalNumber(e.getUTCMinutes(),{unit:"minute"}):p.m(e,t)},s:function(e,t,r){return t==="so"?r.ordinalNumber(e.getUTCSeconds(),{unit:"second"}):p.s(e,t)},S:function(e,t){return p.S(e,t)},X:function(e,t,r,n){var i=n._originalDate||e,o=i.getTimezoneOffset();if(o===0)return"Z";switch(t){case"X":return H(o);case"XXXX":case"XX":return C(o);case"XXXXX":case"XXX":default:return C(o,":")}},x:function(e,t,r,n){var i=n._originalDate||e,o=i.getTimezoneOffset();switch(t){case"x":return H(o);case"xxxx":case"xx":return C(o);case"xxxxx":case"xxx":default:return C(o,":")}},O:function(e,t,r,n){var i=n._originalDate||e,o=i.getTimezoneOffset();switch(t){case"O":case"OO":case"OOO":return"GMT"+$(o,":");case"OOOO":default:return"GMT"+C(o,":")}},z:function(e,t,r,n){var i=n._originalDate||e,o=i.getTimezoneOffset();switch(t){case"z":case"zz":case"zzz":return"GMT"+$(o,":");case"zzzz":default:return"GMT"+C(o,":")}},t:function(e,t,r,n){var i=n._originalDate||e,o=Math.floor(i.getTime()/1e3);return u(o,t.length)},T:function(e,t,r,n){var i=n._originalDate||e,o=i.getTime();return u(o,t.length)}};function $(a,e){var t=a>0?"-":"+",r=Math.abs(a),n=Math.floor(r/60),i=r%60;if(i===0)return t+String(n);var o=e;return t+String(n)+o+u(i,2)}function H(a,e){if(a%60===0){var t=a>0?"-":"+";return t+u(Math.abs(a)/60,2)}return C(a,e)}function C(a,e){var t=e||"",r=a>0?"-":"+",n=Math.abs(a),i=u(Math.floor(n/60),2),o=u(n%60,2);return r+i+t+o}var R=function(e,t){switch(e){case"P":return t.date({width:"short"});case"PP":return t.date({width:"medium"});case"PPP":return t.date({width:"long"});case"PPPP":default:return t.date({width:"full"})}},j=function(e,t){switch(e){case"p":return t.time({width:"short"});case"pp":return t.time({width:"medium"});case"ppp":return t.time({width:"long"});case"pppp":default:return t.time({width:"full"})}},fe=function(e,t){var r=e.match(/(P+)(p+)?/)||[],n=r[1],i=r[2];if(!i)return R(e,t);var o;switch(n){case"P":o=t.dateTime({width:"short"});break;case"PP":o=t.dateTime({width:"medium"});break;case"PPP":o=t.dateTime({width:"long"});break;case"PPPP":default:o=t.dateTime({width:"full"});break}return o.replace("{{date}}",R(n,t)).replace("{{time}}",j(i,t))},me={p:j,P:fe},he=["D","DD"],ve=["YY","YYYY"];function ge(a){return he.indexOf(a)!==-1}function we(a){return ve.indexOf(a)!==-1}function Q(a,e,t){if(a==="YYYY")throw new RangeError("Use `yyyy` instead of `YYYY` (in `".concat(e,"`) for formatting years to the input `").concat(t,"`; see: https://github.com/date-fns/date-fns/blob/master/docs/unicodeTokens.md"));if(a==="YY")throw new RangeError("Use `yy` instead of `YY` (in `".concat(e,"`) for formatting years to the input `").concat(t,"`; see: https://github.com/date-fns/date-fns/blob/master/docs/unicodeTokens.md"));if(a==="D")throw new RangeError("Use `d` instead of `D` (in `".concat(e,"`) for formatting days of the month to the input `").concat(t,"`; see: https://github.com/date-fns/date-fns/blob/master/docs/unicodeTokens.md"));if(a==="DD")throw new RangeError("Use `dd` instead of `DD` (in `".concat(e,"`) for formatting days of the month to the input `").concat(t,"`; see: https://github.com/date-fns/date-fns/blob/master/docs/unicodeTokens.md"))}var be={lessThanXSeconds:{one:"less than a second",other:"less than {{count}} seconds"},xSeconds:{one:"1 second",other:"{{count}} seconds"},halfAMinute:"half a minute",lessThanXMinutes:{one:"less than a minute",other:"less than {{count}} minutes"},xMinutes:{one:"1 minute",other:"{{count}} minutes"},aboutXHours:{one:"about 1 hour",other:"about {{count}} hours"},xHours:{one:"1 hour",other:"{{count}} hours"},xDays:{one:"1 day",other:"{{count}} days"},aboutXWeeks:{one:"about 1 week",other:"about {{count}} weeks"},xWeeks:{one:"1 week",other:"{{count}} weeks"},aboutXMonths:{one:"about 1 month",other:"about {{count}} months"},xMonths:{one:"1 month",other:"{{count}} months"},aboutXYears:{one:"about 1 year",other:"about {{count}} years"},xYears:{one:"1 year",other:"{{count}} years"},overXYears:{one:"over 1 year",other:"over {{count}} years"},almostXYears:{one:"almost 1 year",other:"almost {{count}} years"}},ye=function(e,t,r){var n,i=be[e];return typeof i=="string"?n=i:t===1?n=i.one:n=i.other.replace("{{count}}",t.toString()),r!=null&&r.addSuffix?r.comparison&&r.comparison>0?"in "+n:n+" ago":n};function L(a){return function(){var e=arguments.length>0&&arguments[0]!==void 0?arguments[0]:{},t=e.width?String(e.width):a.defaultWidth,r=a.formats[t]||a.formats[a.defaultWidth];return r}}var pe={full:"EEEE, MMMM do, y",long:"MMMM do, y",medium:"MMM d, y",short:"MM/dd/yyyy"},Te={full:"h:mm:ss a zzzz",long:"h:mm:ss a z",medium:"h:mm:ss a",short:"h:mm a"},Ce={full:"{{date}} 'at' {{time}}",long:"{{date}} 'at' {{time}}",medium:"{{date}}, {{time}}",short:"{{date}}, {{time}}"},Oe={date:L({formats:pe,defaultWidth:"full"}),time:L({formats:Te,defaultWidth:"full"}),dateTime:L({formats:Ce,defaultWidth:"full"})},Me={lastWeek:"'last' eeee 'at' p",yesterday:"'yesterday at' p",today:"'today at' p",tomorrow:"'tomorrow at' p",nextWeek:"eeee 'at' p",other:"P"},De=function(e,t,r,n){return Me[e]};function x(a){return function(e,t){var r=t!=null&&t.context?String(t.context):"standalone",n;if(r==="formatting"&&a.formattingValues){var i=a.defaultFormattingWidth||a.defaultWidth,o=t!=null&&t.width?String(t.width):i;n=a.formattingValues[o]||a.formattingValues[i]}else{var s=a.defaultWidth,l=t!=null&&t.width?String(t.width):a.defaultWidth;n=a.values[l]||a.values[s]}var d=a.argumentCallback?a.argumentCallback(e):e;return n[d]}}var Pe={narrow:["B","A"],abbreviated:["BC","AD"],wide:["Before Christ","Anno Domini"]},ke={narrow:["1","2","3","4"],abbreviated:["Q1","Q2","Q3","Q4"],wide:["1st quarter","2nd quarter","3rd quarter","4th quarter"]},xe={narrow:["J","F","M","A","M","J","J","A","S","O","N","D"],abbreviated:["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],wide:["January","February","March","April","May","June","July","August","September","October","November","December"]},Se={narrow:["S","M","T","W","T","F","S"],short:["Su","Mo","Tu","We","Th","Fr","Sa"],abbreviated:["Sun","Mon","Tue","Wed","Thu","Fri","Sat"],wide:["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"]},We={narrow:{am:"a",pm:"p",midnight:"mi",noon:"n",morning:"morning",afternoon:"afternoon",evening:"evening",night:"night"},abbreviated:{am:"AM",pm:"PM",midnight:"midnight",noon:"noon",morning:"morning",afternoon:"afternoon",evening:"evening",night:"night"},wide:{am:"a.m.",pm:"p.m.",midnight:"midnight",noon:"noon",morning:"morning",afternoon:"afternoon",evening:"evening",night:"night"}},Ue={narrow:{am:"a",pm:"p",midnight:"mi",noon:"n",morning:"in the morning",afternoon:"in the afternoon",evening:"in the evening",night:"at night"},abbreviated:{am:"AM",pm:"PM",midnight:"midnight",noon:"noon",morning:"in the morning",afternoon:"in the afternoon",evening:"in the evening",night:"at night"},wide:{am:"a.m.",pm:"p.m.",midnight:"midnight",noon:"noon",morning:"in the morning",afternoon:"in the afternoon",evening:"in the evening",night:"at night"}},Ye=function(e,t){var r=Number(e),n=r%100;if(n>20||n<10)switch(n%10){case 1:return r+"st";case 2:return r+"nd";case 3:return r+"rd"}return r+"th"},Ee={ordinalNumber:Ye,era:x({values:Pe,defaultWidth:"wide"}),quarter:x({values:ke,defaultWidth:"wide",argumentCallback:function(e){return e-1}}),month:x({values:xe,defaultWidth:"wide"}),day:x({values:Se,defaultWidth:"wide"}),dayPeriod:x({values:We,defaultWidth:"wide",formattingValues:Ue,defaultFormattingWidth:"wide"})};function S(a){return function(e){var t=arguments.length>1&&arguments[1]!==void 0?arguments[1]:{},r=t.width,n=r&&a.matchPatterns[r]||a.matchPatterns[a.defaultMatchWidth],i=e.match(n);if(!i)return null;var o=i[0],s=r&&a.parsePatterns[r]||a.parsePatterns[a.defaultParseWidth],l=Array.isArray(s)?Ne(s,function(c){return c.test(o)}):_e(s,function(c){return c.test(o)}),d;d=a.valueCallback?a.valueCallback(l):l,d=t.valueCallback?t.valueCallback(d):d;var f=e.slice(o.length);return{value:d,rest:f}}}function _e(a,e){for(var t in a)if(a.hasOwnProperty(t)&&e(a[t]))return t}function Ne(a,e){for(var t=0;t<a.length;t++)if(e(a[t]))return t}function Fe(a){return function(e){var t=arguments.length>1&&arguments[1]!==void 0?arguments[1]:{},r=e.match(a.matchPattern);if(!r)return null;var n=r[0],i=e.match(a.parsePattern);if(!i)return null;var o=a.valueCallback?a.valueCallback(i[0]):i[0];o=t.valueCallback?t.valueCallback(o):o;var s=e.slice(n.length);return{value:o,rest:s}}}var qe=/^(\d+)(th|st|nd|rd)?/i,Le=/\d+/i,$e={narrow:/^(b|a)/i,abbreviated:/^(b\.?\s?c\.?|b\.?\s?c\.?\s?e\.?|a\.?\s?d\.?|c\.?\s?e\.?)/i,wide:/^(before christ|before common era|anno domini|common era)/i},He={any:[/^b/i,/^(a|c)/i]},Re={narrow:/^[1234]/i,abbreviated:/^q[1234]/i,wide:/^[1234](th|st|nd|rd)? quarter/i},Qe={any:[/1/i,/2/i,/3/i,/4/i]},Xe={narrow:/^[jfmasond]/i,abbreviated:/^(jan|feb|mar|apr|may|jun|jul|aug|sep|oct|nov|dec)/i,wide:/^(january|february|march|april|may|june|july|august|september|october|november|december)/i},Ge={narrow:[/^j/i,/^f/i,/^m/i,/^a/i,/^m/i,/^j/i,/^j/i,/^a/i,/^s/i,/^o/i,/^n/i,/^d/i],any:[/^ja/i,/^f/i,/^mar/i,/^ap/i,/^may/i,/^jun/i,/^jul/i,/^au/i,/^s/i,/^o/i,/^n/i,/^d/i]},Ie={narrow:/^[smtwf]/i,short:/^(su|mo|tu|we|th|fr|sa)/i,abbreviated:/^(sun|mon|tue|wed|thu|fri|sat)/i,wide:/^(sunday|monday|tuesday|wednesday|thursday|friday|saturday)/i},je={narrow:[/^s/i,/^m/i,/^t/i,/^w/i,/^t/i,/^f/i,/^s/i],any:[/^su/i,/^m/i,/^tu/i,/^w/i,/^th/i,/^f/i,/^sa/i]},Be={narrow:/^(a|p|mi|n|(in the|at) (morning|afternoon|evening|night))/i,any:/^([ap]\.?\s?m\.?|midnight|noon|(in the|at) (morning|afternoon|evening|night))/i},Ae={any:{am:/^a/i,pm:/^p/i,midnight:/^mi/i,noon:/^no/i,morning:/morning/i,afternoon:/afternoon/i,evening:/evening/i,night:/night/i}},Ve={ordinalNumber:Fe({matchPattern:qe,parsePattern:Le,valueCallback:function(e){return parseInt(e,10)}}),era:S({matchPatterns:$e,defaultMatchWidth:"wide",parsePatterns:He,defaultParseWidth:"any"}),quarter:S({matchPatterns:Re,defaultMatchWidth:"wide",parsePatterns:Qe,defaultParseWidth:"any",valueCallback:function(e){return e+1}}),month:S({matchPatterns:Xe,defaultMatchWidth:"wide",parsePatterns:Ge,defaultParseWidth:"any"}),day:S({matchPatterns:Ie,defaultMatchWidth:"wide",parsePatterns:je,defaultParseWidth:"any"}),dayPeriod:S({matchPatterns:Be,defaultMatchWidth:"any",parsePatterns:Ae,defaultParseWidth:"any"})},Je={code:"en-US",formatDistance:ye,formatLong:Oe,formatRelative:De,localize:Ee,match:Ve,options:{weekStartsOn:0,firstWeekContainsDate:1}},Ke=/[yYQqMLwIdDecihHKkms]o|(\w)\1*|''|'(''|[^'])+('|$)|./g,ze=/P+p+|P+|p+|''|'(''|[^'])+('|$)|./g,Ze=/^'([^]*?)'?$/,et=/''/g,tt=/[a-zA-Z]/;function nt(a,e,t){var r,n,i,o,s,l,d,f,c,v,m,w,D,T;h(2,arguments);var N=String(e),P=_(),k=(r=(n=void 0)!==null&&n!==void 0?n:P.locale)!==null&&r!==void 0?r:Je,F=O((i=(o=(s=(l=void 0)!==null&&l!==void 0?l:void 0)!==null&&s!==void 0?s:P.firstWeekContainsDate)!==null&&o!==void 0?o:(d=P.locale)===null||d===void 0||(f=d.options)===null||f===void 0?void 0:f.firstWeekContainsDate)!==null&&i!==void 0?i:1);if(!(F>=1&&F<=7))throw new RangeError("firstWeekContainsDate must be between 1 and 7 inclusively");var q=O((c=(v=(m=(w=void 0)!==null&&w!==void 0?w:void 0)!==null&&m!==void 0?m:P.weekStartsOn)!==null&&v!==void 0?v:(D=P.locale)===null||D===void 0||(T=D.options)===null||T===void 0?void 0:T.weekStartsOn)!==null&&c!==void 0?c:0);if(!(q>=0&&q<=6))throw new RangeError("weekStartsOn must be between 0 and 6 inclusively");if(!k.localize)throw new RangeError("locale must contain localize property");if(!k.formatLong)throw new RangeError("locale must contain formatLong property");var W=b(a);if(!te(W))throw new RangeError("Invalid time value");var B=Z(W),A=re(W,B),V={firstWeekContainsDate:F,weekStartsOn:q,locale:k,_originalDate:W},J=N.match(ze).map(function(g){var y=g[0];if(y==="p"||y==="P"){var U=me[y];return U(g,k.formatLong)}return g}).join("").match(Ke).map(function(g){if(g==="''")return"'";var y=g[0];if(y==="'")return rt(g);var U=ce[y];if(U)return we(g)&&Q(g,e,String(a)),ge(g)&&Q(g,e,String(a)),U(A,g,k.localize,V);if(y.match(tt))throw new RangeError("Format string contains an unescaped latin alphabet character `"+y+"`");return g}).join("");return J}function rt(a){var e=a.match(Ze);return e?e[1].replace(et,"'"):a}export{nt as f};
