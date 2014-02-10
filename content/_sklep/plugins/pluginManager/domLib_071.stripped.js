
var domLib_userAgent=navigator.userAgent.toLowerCase();var domLib_isMac=navigator.appVersion.indexOf('Mac')!=-1;var domLib_isWin=domLib_userAgent.indexOf('windows')!=-1;var domLib_isOpera=domLib_userAgent.indexOf('opera')!=-1;var domLib_isOpera7up=domLib_userAgent.match(/opera.(7|8)/i);var domLib_isSafari=domLib_userAgent.indexOf('safari')!=-1;var domLib_isKonq=domLib_userAgent.indexOf('konqueror')!=-1;var domLib_isKHTML=(domLib_isKonq||domLib_isSafari||domLib_userAgent.indexOf('khtml')!=-1);var domLib_isIE=(!domLib_isKHTML&&!domLib_isOpera&&(domLib_userAgent.indexOf('msie 5')!=-1||domLib_userAgent.indexOf('msie 6')!=-1||domLib_userAgent.indexOf('msie 7')!=-1));var domLib_isIE5up=domLib_isIE;var domLib_isIE50=(domLib_isIE&&domLib_userAgent.indexOf('msie 5.0')!=-1);var domLib_isIE55=(domLib_isIE&&domLib_userAgent.indexOf('msie 5.5')!=-1);var domLib_isIE5=(domLib_isIE50||domLib_isIE55);var domLib_isGecko=domLib_userAgent.indexOf('gecko/')!=-1;var domLib_isMacIE=(domLib_isIE&&domLib_isMac);var domLib_isIE55up=domLib_isIE5up&&!domLib_isIE50&&!domLib_isMacIE;var domLib_isIE6up=domLib_isIE55up&&!domLib_isIE55;var domLib_standardsMode=(document.compatMode&&document.compatMode=='CSS1Compat');var domLib_useLibrary=(domLib_isOpera7up||domLib_isKHTML||domLib_isIE5up||domLib_isGecko||domLib_isMacIE||document.defaultView);var domLib_hasBrokenTimeout=(domLib_isMacIE||(domLib_isKonq&&domLib_userAgent.match(/konqueror\/3.([2-9])/)==null));var domLib_canFade=(domLib_isGecko||domLib_isIE||domLib_isSafari||domLib_isOpera);var domLib_canDrawOverSelect=(domLib_isMac||domLib_isOpera||domLib_isGecko);var domLib_canDrawOverFlash=(domLib_isMac||domLib_isWin);var domLib_eventTarget=domLib_isIE?'srcElement':'currentTarget';var domLib_eventButton=domLib_isIE?'button':'which';var domLib_eventTo=domLib_isIE?'toElement':'relatedTarget';var domLib_stylePointer=domLib_isIE?'hand':'pointer';var domLib_styleNoMaxWidth=domLib_isOpera?'10000px':'none';var domLib_hidePosition='-1000px';var domLib_scrollbarWidth=14;var domLib_autoId=1;var domLib_zIndex=100;var domLib_collisionElements;var domLib_collisionsCached=false;var domLib_timeoutStateId=0;var domLib_timeoutStates=new Hash();if(!document.ELEMENT_NODE)
{document.ELEMENT_NODE=1;document.ATTRIBUTE_NODE=2;document.TEXT_NODE=3;document.DOCUMENT_NODE=9;document.DOCUMENT_FRAGMENT_NODE=11;}
function domLib_clone(obj)
{var copy={};for(var i in obj)
{var value=obj[i];try
{if(value!=null&&typeof(value)=='object'&&value!=window&&!value.nodeType)
{copy[i]=domLib_clone(value);}
else
{copy[i]=value;}}
catch(e)
{copy[i]=value;}}
return copy;}
function Hash()
{this.length=0;this.numericLength=0;this.elementData=[];for(var i=0;i<arguments.length;i+=2)
{if(typeof(arguments[i+1])!='undefined')
{this.elementData[arguments[i]]=arguments[i+1];this.length++;if(arguments[i]==parseInt(arguments[i]))
{this.numericLength++;}}}}
Hash.prototype.get=function(in_key)
{return this.elementData[in_key];}
Hash.prototype.set=function(in_key,in_value)
{if(typeof(in_value)!='undefined')
{if(typeof(this.elementData[in_key])=='undefined')
{this.length++;if(in_key==parseInt(in_key))
{this.numericLength++;}}
return this.elementData[in_key]=in_value;}
return false;}
Hash.prototype.remove=function(in_key)
{var tmp_value;if(typeof(this.elementData[in_key])!='undefined')
{this.length--;if(in_key==parseInt(in_key))
{this.numericLength--;}
tmp_value=this.elementData[in_key];delete this.elementData[in_key];}
return tmp_value;}
Hash.prototype.size=function()
{return this.length;}
Hash.prototype.has=function(in_key)
{return typeof(this.elementData[in_key])!='undefined';}
Hash.prototype.find=function(in_obj)
{for(var tmp_key in this.elementData)
{if(this.elementData[tmp_key]==in_obj)
{return tmp_key;}}}
Hash.prototype.merge=function(in_hash)
{for(var tmp_key in in_hash.elementData)
{if(typeof(this.elementData[tmp_key])=='undefined')
{this.length++;if(tmp_key==parseInt(tmp_key))
{this.numericLength++;}}
this.elementData[tmp_key]=in_hash.elementData[tmp_key];}}
Hash.prototype.compare=function(in_hash)
{if(this.length!=in_hash.length)
{return false;}
for(var tmp_key in this.elementData)
{if(this.elementData[tmp_key]!=in_hash.elementData[tmp_key])
{return false;}}
return true;}
function domLib_isDescendantOf(in_object,in_ancestor)
{if(in_object==in_ancestor)
{return true;}
while(in_object!=document.documentElement)
{try
{if((tmp_object=in_object.offsetParent)&&tmp_object==in_ancestor)
{return true;}
else if((tmp_object=in_object.parentNode)==in_ancestor)
{return true;}
else
{in_object=tmp_object;}}
catch(e)
{return true;}}
return false;}
function domLib_detectCollisions(in_object,in_recover,in_useCache)
{if(!domLib_collisionsCached)
{var tags=[];if(!domLib_canDrawOverFlash)
{tags[tags.length]='object';}
if(!domLib_canDrawOverSelect)
{tags[tags.length]='select';}
domLib_collisionElements=domLib_getElementsByTagNames(tags,true);domLib_collisionsCached=in_useCache;}
if(in_recover)
{for(var cnt=0;cnt<domLib_collisionElements.length;cnt++)
{var thisElement=domLib_collisionElements[cnt];if(!thisElement.hideList)
{thisElement.hideList=new Hash();}
thisElement.hideList.remove(in_object.id);if(!thisElement.hideList.length)
{domLib_collisionElements[cnt].style.visibility='visible';if(domLib_isKonq)
{domLib_collisionElements[cnt].style.display='';}}}
return;}
else if(domLib_collisionElements.length==0)
{return;}
var objectOffsets=domLib_getOffsets(in_object);for(var cnt=0;cnt<domLib_collisionElements.length;cnt++)
{var thisElement=domLib_collisionElements[cnt];if(domLib_isDescendantOf(thisElement,in_object))
{continue;}
if(domLib_isKonq&&thisElement.tagName=='SELECT'&&(thisElement.size<=1&&!thisElement.multiple))
{continue;}
if(!thisElement.hideList)
{thisElement.hideList=new Hash();}
var selectOffsets=domLib_getOffsets(thisElement);var center2centerDistance=Math.sqrt(Math.pow(selectOffsets.get('leftCenter')-objectOffsets.get('leftCenter'),2)+Math.pow(selectOffsets.get('topCenter')-objectOffsets.get('topCenter'),2));var radiusSum=selectOffsets.get('radius')+objectOffsets.get('radius');if(center2centerDistance<radiusSum)
{if((objectOffsets.get('leftCenter')<=selectOffsets.get('leftCenter')&&objectOffsets.get('right')<selectOffsets.get('left'))||(objectOffsets.get('leftCenter')>selectOffsets.get('leftCenter')&&objectOffsets.get('left')>selectOffsets.get('right'))||(objectOffsets.get('topCenter')<=selectOffsets.get('topCenter')&&objectOffsets.get('bottom')<selectOffsets.get('top'))||(objectOffsets.get('topCenter')>selectOffsets.get('topCenter')&&objectOffsets.get('top')>selectOffsets.get('bottom')))
{thisElement.hideList.remove(in_object.id);if(!thisElement.hideList.length)
{thisElement.style.visibility='visible';if(domLib_isKonq)
{thisElement.style.display='';}}}
else
{thisElement.hideList.set(in_object.id,true);thisElement.style.visibility='hidden';if(domLib_isKonq)
{thisElement.style.display='none';}}}}}
function domLib_getOffsets(in_object)
{var originalObject=in_object;var originalWidth=in_object.offsetWidth;var originalHeight=in_object.offsetHeight;var offsetLeft=0;var offsetTop=0;while(in_object)
{offsetLeft+=in_object.offsetLeft;offsetTop+=in_object.offsetTop;in_object=in_object.offsetParent;}
if(domLib_isMacIE){offsetLeft+=10;offsetTop+=10;}
return new Hash('left',offsetLeft,'top',offsetTop,'right',offsetLeft+originalWidth,'bottom',offsetTop+originalHeight,'leftCenter',offsetLeft+originalWidth/2,'topCenter',offsetTop+originalHeight/2,'radius',Math.max(originalWidth,originalHeight));}
function domLib_setTimeout(in_function,in_timeout,in_args)
{if(typeof(in_args)=='undefined')
{in_args=[];}
if(in_timeout==-1)
{return;}
else if(in_timeout==0)
{in_function(in_args);return 0;}
var args=domLib_clone(in_args);if(!domLib_hasBrokenTimeout)
{return setTimeout(function(){in_function(args);},in_timeout);}
else
{var id=domLib_timeoutStateId++;var data=new Hash();data.set('function',in_function);data.set('args',args);domLib_timeoutStates.set(id,data);data.set('timeoutId',setTimeout('domLib_timeoutStates.get('+id+').get(\'function\')(domLib_timeoutStates.get('+id+').get(\'args\')); domLib_timeoutStates.remove('+id+');',in_timeout));return id;}}
function domLib_clearTimeout(in_id)
{if(!domLib_hasBrokenTimeout)
{clearTimeout(in_id);}
else
{if(domLib_timeoutStates.has(in_id))
{clearTimeout(domLib_timeoutStates.get(in_id).get('timeoutId'))
domLib_timeoutStates.remove(in_id);}}}
function domLib_getEventPosition(in_eventObj)
{var eventPosition=new Hash('x',0,'y',0,'scrollX',0,'scrollY',0);if(domLib_isIE)
{var doc=(domLib_standardsMode?document.documentElement:document.body);if(doc)
{eventPosition.set('x',in_eventObj.clientX+doc.scrollLeft);eventPosition.set('y',in_eventObj.clientY+doc.scrollTop);eventPosition.set('scrollX',doc.scrollLeft);eventPosition.set('scrollY',doc.scrollTop);}}
else
{eventPosition.set('x',in_eventObj.pageX);eventPosition.set('y',in_eventObj.pageY);eventPosition.set('scrollX',in_eventObj.pageX-in_eventObj.clientX);eventPosition.set('scrollY',in_eventObj.pageY-in_eventObj.clientY);}
return eventPosition;}
function domLib_cancelBubble(in_event)
{var eventObj=in_event?in_event:window.event;eventObj.cancelBubble=true;}
function domLib_getIFrameReference(in_frame)
{if(domLib_isGecko||domLib_isIE)
{return in_frame.frameElement;}
else
{var name=in_frame.name;if(!name||!in_frame.parent)
{return;}
var candidates=in_frame.parent.document.getElementsByTagName('iframe');for(var i=0;i<candidates.length;i++)
{if(candidates[i].name==name)
{return candidates[i];}}}}
function domLib_getElementsByClass(in_class)
{var elements=domLib_isIE5?document.all:document.getElementsByTagName('*');var matches=[];var cnt=0;for(var i=0;i<elements.length;i++)
{if((" "+elements[i].className+" ").indexOf(" "+in_class+" ")!=-1)
{matches[cnt++]=elements[i];}}
return matches;}
function domLib_getElementsByTagNames(in_list,in_excludeHidden)
{var elements=[];for(var i=0;i<in_list.length;i++)
{var matches=document.getElementsByTagName(in_list[i]);for(var j=0;j<matches.length;j++)
{if(in_excludeHidden&&domLib_getComputedStyle(matches[j],'visibility')=='hidden')
{continue;}
elements[elements.length]=matches[j];}}
return elements;}
function domLib_getComputedStyle(in_obj,in_property)
{if(domLib_isIE)
{var humpBackProp=in_property.replace(/-(.)/,function(a,b){return b.toUpperCase();});return eval('in_obj.currentStyle.'+humpBackProp);}
else if(domLib_isKonq)
{var humpBackProp=in_property.replace(/-(.)/,function(a,b){return b.toUpperCase();});return eval('in_obj.style.'+in_property);}
else
{return document.defaultView.getComputedStyle(in_obj,null).getPropertyValue(in_property);}}
function makeTrue()
{return true;}
function makeFalse()
{return false;}