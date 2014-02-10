
var domTT_offsetX=(domLib_isIE?-2:0);var domTT_offsetY=(domLib_isIE?4:2);var domTT_direction='southeast';var domTT_mouseHeight=domLib_isIE?13:19;var domTT_closeLink='X';var domTT_closeAction='hide';var domTT_activateDelay=500;var domTT_maxWidth=false;var domTT_styleClass='domTT';var domTT_fade='neither';var domTT_lifetime=0;var domTT_grid=0;var domTT_trailDelay=200;var domTT_useGlobalMousePosition=true;var domTT_screenEdgeDetection=true;var domTT_screenEdgePadding=4;var domTT_oneOnly=false;var domTT_draggable=false;if(typeof(domTT_dragEnabled)=='undefined')
{domTT_dragEnabled=false;}
var domTT_predefined=new Hash();var domTT_tooltips=new Hash();var domTT_lastOpened=0;if(domLib_useLibrary&&domTT_useGlobalMousePosition)
{var domTT_mousePosition=new Hash();document.onmousemove=function(in_event)
{if(typeof(in_event)=='undefined')
{in_event=event;}
domTT_mousePosition=domLib_getEventPosition(in_event);if(domTT_dragEnabled&&domTT_dragMouseDown)
{domTT_dragUpdate(in_event);}}}
function domTT_activate(in_this,in_event)
{if(!domLib_useLibrary){return false;}
if(typeof(in_event)=='undefined')
{in_event=window.event;}
var owner=document.body;if(in_event.type.match(/key|mouse|click|contextmenu/i))
{if(in_this.nodeType&&in_this.nodeType!=document.DOCUMENT_NODE)
{var owner=in_this;}}
else
{if(typeof(in_this)!='object'&&!(owner=domTT_tooltips.get(in_this)))
{owner=document.body.appendChild(document.createElement('div'));owner.style.display='none';owner.id=in_this;}}
if(!owner.id)
{owner.id='__autoId'+domLib_autoId++;}
if(domTT_oneOnly&&domTT_lastOpened)
{domTT_deactivate(domTT_lastOpened);}
domTT_lastOpened=owner.id;var tooltip=domTT_tooltips.get(owner.id);if(tooltip)
{if(tooltip.get('eventType')!=in_event.type)
{if(tooltip.get('type')=='greasy')
{tooltip.set('closeAction','destroy');domTT_deactivate(owner.id);}
else if(tooltip.get('status')!='inactive')
{return owner.id;}}
else
{if(tooltip.get('status')=='inactive')
{tooltip.set('status','pending');tooltip.set('activateTimeout',domLib_setTimeout(domTT_runShow,tooltip.get('delay'),[owner.id,in_event]));return owner.id;}
else
{return owner.id;}}}
var options=new Hash('caption','','content','','clearMouse',true,'closeAction',domTT_closeAction,'closeLink',domTT_closeLink,'delay',domTT_activateDelay,'direction',domTT_direction,'draggable',domTT_draggable,'fade',domTT_fade,'fadeMax',100,'grid',domTT_grid,'id','[domTT]'+owner.id,'inframe',false,'lifetime',domTT_lifetime,'offsetX',domTT_offsetX,'offsetY',domTT_offsetY,'parent',document.body,'position','absolute','styleClass',domTT_styleClass,'type','greasy','trail',false,'lazy',false);for(var i=2;i<arguments.length;i+=2)
{if(arguments[i]=='predefined')
{var predefinedOptions=domTT_predefined.get(arguments[i+1]);for(var j in predefinedOptions.elementData)
{options.set(j,predefinedOptions.get(j));}}
else
{options.set(arguments[i],arguments[i+1]);}}
options.set('eventType',in_event.type);if(options.has('statusText'))
{try{window.status=options.get('statusText');}catch(e){}}
if(!options.has('content')||options.get('content')==''||options.get('content')==null)
{if(typeof(owner.onmouseout)!='function')
{owner.onmouseout=function(in_event){domTT_mouseout(this,in_event);};}
return owner.id;}
options.set('owner',owner);domTT_create(options);options.set('delay',in_event.type.match(/click|mousedown|contextmenu/i)?0:parseInt(options.get('delay')));domTT_tooltips.set(owner.id,options);domTT_tooltips.set(options.get('id'),options);options.set('status','pending');options.set('activateTimeout',domLib_setTimeout(domTT_runShow,options.get('delay'),[owner.id,in_event]));return owner.id;}
function domTT_create(in_options)
{var tipOwner=in_options.get('owner');var parentObj=in_options.get('parent');var parentDoc=parentObj.ownerDocument||parentObj.document;var tipObj=parentObj.appendChild(parentDoc.createElement('div'));tipObj.style.position='absolute';tipObj.style.left='0px';tipObj.style.top='0px';tipObj.style.visibility='hidden';tipObj.id=in_options.get('id');tipObj.className=in_options.get('styleClass');var content;var tableLayout=false;if(in_options.get('caption')||(in_options.get('type')=='sticky'&&in_options.get('caption')!==false))
{tableLayout=true;var tipLayoutTable=tipObj.appendChild(parentDoc.createElement('table'));tipLayoutTable.style.borderCollapse='collapse';if(domLib_isKHTML)
{tipLayoutTable.cellSpacing=0;}
var tipLayoutTbody=tipLayoutTable.appendChild(parentDoc.createElement('tbody'));var numCaptionCells=0;var captionRow=tipLayoutTbody.appendChild(parentDoc.createElement('tr'));var captionCell=captionRow.appendChild(parentDoc.createElement('td'));captionCell.style.padding='0px';var caption=captionCell.appendChild(parentDoc.createElement('div'));caption.className='caption';if(domLib_isIE50)
{caption.style.height='100%';}
if(in_options.get('caption').nodeType)
{caption.appendChild(in_options.get('caption').cloneNode(1));}
else
{caption.innerHTML=in_options.get('caption');}
if(in_options.get('type')=='sticky')
{var numCaptionCells=2;var closeLinkCell=captionRow.appendChild(parentDoc.createElement('td'));closeLinkCell.style.padding='0px';var closeLink=closeLinkCell.appendChild(parentDoc.createElement('div'));closeLink.className='caption';if(domLib_isIE50)
{closeLink.style.height='100%';}
closeLink.style.textAlign='right';closeLink.style.cursor=domLib_stylePointer;closeLink.style.borderLeftWidth=caption.style.borderRightWidth='0px';closeLink.style.paddingLeft=caption.style.paddingRight='0px';closeLink.style.marginLeft=caption.style.marginRight='0px';if(in_options.get('closeLink').nodeType)
{closeLink.appendChild(in_options.get('closeLink').cloneNode(1));}
else
{closeLink.innerHTML=in_options.get('closeLink');}
closeLink.onclick=function(){domTT_deactivate(tipOwner.id);};closeLink.onmousedown=function(in_event){if(typeof(in_event)=='undefined'){in_event=event;}in_event.cancelBubble=true;};if(domLib_isMacIE)
{closeLinkCell.appendChild(parentDoc.createTextNode("\n"));}}
if(domLib_isMacIE)
{captionCell.appendChild(parentDoc.createTextNode("\n"));}
var contentRow=tipLayoutTbody.appendChild(parentDoc.createElement('tr'));var contentCell=contentRow.appendChild(parentDoc.createElement('td'));contentCell.style.padding='0px';if(numCaptionCells)
{if(domLib_isIE||domLib_isOpera)
{contentCell.colSpan=numCaptionCells;}
else
{contentCell.setAttribute('colspan',numCaptionCells);}}
content=contentCell.appendChild(parentDoc.createElement('div'));if(domLib_isIE50)
{content.style.height='100%';}}
else
{content=tipObj.appendChild(parentDoc.createElement('div'));}
content.className='contents';if(in_options.get('content').nodeType)
{content.appendChild(in_options.get('content').cloneNode(1));}
else
{content.innerHTML=in_options.get('content');}
if(in_options.has('width'))
{tipObj.style.width=parseInt(in_options.get('width'))+'px';}
var maxWidth=domTT_maxWidth;if(in_options.has('maxWidth'))
{if((maxWidth=in_options.get('maxWidth'))===false)
{tipObj.style.maxWidth=domLib_styleNoMaxWidth;}
else
{maxWidth=parseInt(in_options.get('maxWidth'));tipObj.style.maxWidth=maxWidth+'px';}}
if(maxWidth!==false&&(domLib_isIE||domLib_isKHTML)&&tipObj.offsetWidth>maxWidth)
{tipObj.style.width=maxWidth+'px';}
in_options.set('offsetWidth',tipObj.offsetWidth);in_options.set('offsetHeight',tipObj.offsetHeight);if(domLib_isKonq&&tableLayout&&!tipObj.style.width)
{var left=document.defaultView.getComputedStyle(tipObj,'').getPropertyValue('border-left-width');var right=document.defaultView.getComputedStyle(tipObj,'').getPropertyValue('border-right-width');left=left.substring(left.indexOf(':')+2,left.indexOf(';'));right=right.substring(right.indexOf(':')+2,right.indexOf(';'));var correction=2*((left?parseInt(left):0)+(right?parseInt(right):0));tipObj.style.width=(tipObj.offsetWidth-correction)+'px';}
if(domLib_isIE||domLib_isOpera)
{if(!tipObj.style.width)
{tipObj.style.width=(tipObj.offsetWidth-2)+'px';}
tipObj.style.height=(tipObj.offsetHeight-2)+'px';}
var offsetX,offsetY;if(in_options.get('position')=='absolute'&&!(in_options.has('x')&&in_options.has('y')))
{switch(in_options.get('direction'))
{case'northeast':offsetX=in_options.get('offsetX');offsetY=0-tipObj.offsetHeight-in_options.get('offsetY');break;case'northwest':offsetX=0-tipObj.offsetWidth-in_options.get('offsetX');offsetY=0-tipObj.offsetHeight-in_options.get('offsetY');break;case'north':offsetX=0-parseInt(tipObj.offsetWidth/2);offsetY=0-tipObj.offsetHeight-in_options.get('offsetY');break;case'southwest':offsetX=0-tipObj.offsetWidth-in_options.get('offsetX');offsetY=in_options.get('offsetY');break;case'southeast':offsetX=in_options.get('offsetX');offsetY=in_options.get('offsetY');break;case'south':offsetX=0-parseInt(tipObj.offsetWidth/2);offsetY=in_options.get('offsetY');break;}
if(in_options.get('inframe'))
{var iframeObj=domLib_getIFrameReference(window);if(iframeObj)
{var frameOffsets=domLib_getOffsets(iframeObj);offsetX+=frameOffsets.get('left');offsetY+=frameOffsets.get('top');}}}
else
{offsetX=0;offsetY=0;in_options.set('trail',false);}
in_options.set('offsetX',offsetX);in_options.set('offsetY',offsetY);if(in_options.get('clearMouse')&&in_options.get('direction').indexOf('south')!=-1)
{in_options.set('mouseOffset',domTT_mouseHeight);}
else
{in_options.set('mouseOffset',0);}
if(domLib_canFade&&typeof(Fadomatic)=='function')
{if(in_options.get('fade')!='neither')
{var fadeHandler=new Fadomatic(tipObj,10,0,0,in_options.get('fadeMax'));in_options.set('fadeHandler',fadeHandler);}}
else
{in_options.set('fade','neither');}
if(in_options.get('trail')&&typeof(tipOwner.onmousemove)!='function')
{tipOwner.onmousemove=function(in_event){domTT_mousemove(this,in_event);};}
if(typeof(tipOwner.onmouseout)!='function')
{tipOwner.onmouseout=function(in_event){domTT_mouseout(this,in_event);};}
if(in_options.get('type')=='sticky')
{if(in_options.get('position')=='absolute'&&domTT_dragEnabled&&in_options.get('draggable'))
{if(domLib_isIE)
{captionRow.onselectstart=function(){return false;};}
captionRow.onmousedown=function(in_event){domTT_dragStart(tipObj,in_event);};captionRow.onmousemove=function(in_event){domTT_dragUpdate(in_event);};captionRow.onmouseup=function(){domTT_dragStop();};}}
else if(in_options.get('type')=='velcro')
{tipObj.onmouseout=function(in_event){if(typeof(in_event)=='undefined'){in_event=event;}if(!domLib_isDescendantOf(in_event[domLib_eventTo],tipObj)){domTT_deactivate(tipOwner.id);}};}
if(in_options.get('position')=='relative')
{tipObj.style.position='relative';}
in_options.set('node',tipObj);in_options.set('status','inactive');}
function domTT_show(in_id,in_event)
{var tooltip=domTT_tooltips.get(in_id);var status=tooltip.get('status');var tipObj=tooltip.get('node');if(tooltip.get('position')=='absolute')
{var mouseX,mouseY;if(tooltip.has('x')&&tooltip.has('y'))
{mouseX=tooltip.get('x');mouseY=tooltip.get('y');}
else if(!domTT_useGlobalMousePosition||status=='active'||tooltip.get('delay')==0)
{var eventPosition=domLib_getEventPosition(in_event);var eventX=eventPosition.get('x');var eventY=eventPosition.get('y');if(tooltip.get('inframe'))
{eventX-=eventPosition.get('scrollX');eventY-=eventPosition.get('scrollY');}
if(status=='active'&&tooltip.get('trail')!==true)
{var trail=tooltip.get('trail');if(trail=='x')
{mouseX=eventX;mouseY=tooltip.get('mouseY');}
else if(trail=='y')
{mouseX=tooltip.get('mouseX');mouseY=eventY;}}
else
{mouseX=eventX;mouseY=eventY;}}
else
{mouseX=domTT_mousePosition.get('x');mouseY=domTT_mousePosition.get('y');if(tooltip.get('inframe'))
{mouseX-=domTT_mousePosition.get('scrollX');mouseY-=domTT_mousePosition.get('scrollY');}}
if(tooltip.get('grid'))
{if(in_event.type!='mousemove'||(status=='active'&&(Math.abs(tooltip.get('lastX')-mouseX)>tooltip.get('grid')||Math.abs(tooltip.get('lastY')-mouseY)>tooltip.get('grid'))))
{tooltip.set('lastX',mouseX);tooltip.set('lastY',mouseY);}
else
{return false;}}
tooltip.set('mouseX',mouseX);tooltip.set('mouseY',mouseY);var coordinates;if(domTT_screenEdgeDetection)
{coordinates=domTT_correctEdgeBleed(tooltip.get('offsetWidth'),tooltip.get('offsetHeight'),mouseX,mouseY,tooltip.get('offsetX'),tooltip.get('offsetY'),tooltip.get('mouseOffset'),tooltip.get('inframe')?window.parent:window);}
else
{coordinates={'x':mouseX+tooltip.get('offsetX'),'y':mouseY+tooltip.get('offsetY')+tooltip.get('mouseOffset')};}
tipObj.style.left=coordinates.x+'px';tipObj.style.top=coordinates.y+'px';tipObj.style.zIndex=domLib_zIndex++;}
if(status=='pending')
{tooltip.set('status','active');tipObj.style.display='';tipObj.style.visibility='visible';var fade=tooltip.get('fade');if(fade!='neither')
{var fadeHandler=tooltip.get('fadeHandler');if(fade=='out'||fade=='both')
{fadeHandler.haltFade();if(fade=='out')
{fadeHandler.halt();}}
if(fade=='in'||fade=='both')
{fadeHandler.fadeIn();}}
if(tooltip.get('type')=='greasy'&&tooltip.get('lifetime')!=0)
{tooltip.set('lifetimeTimeout',domLib_setTimeout(domTT_runDeactivate,tooltip.get('lifetime'),[tipObj.id]));}}
if(tooltip.get('position')=='absolute')
{domLib_detectCollisions(tipObj);}}
function domTT_close(in_handle)
{var id;if(typeof(in_handle)=='object'&&in_handle.nodeType)
{var obj=in_handle;while(!obj.id||!domTT_tooltips.get(obj.id))
{obj=obj.parentNode;if(obj.nodeType!=document.ELEMENT_NODE){return;}}
id=obj.id;}
else
{id=in_handle;}
domTT_deactivate(id);}
function domTT_deactivate(in_id)
{var tooltip=domTT_tooltips.get(in_id);if(tooltip)
{var status=tooltip.get('status');if(status=='pending')
{domLib_clearTimeout(tooltip.get('activateTimeout'));tooltip.set('status','inactive');}
else if(status=='active')
{if(tooltip.get('lifetime'))
{domLib_clearTimeout(tooltip.get('lifetimeTimeout'));}
var tipObj=tooltip.get('node');if(tooltip.get('closeAction')=='hide')
{var fade=tooltip.get('fade');if(fade!='neither')
{var fadeHandler=tooltip.get('fadeHandler');if(fade=='out'||fade=='both')
{fadeHandler.fadeOut();}
else
{fadeHandler.hide();}}
else
{tipObj.style.display='none';}}
else
{tooltip.get('parent').removeChild(tipObj);domTT_tooltips.remove(tooltip.get('owner').id);domTT_tooltips.remove(tooltip.get('id'));}
tooltip.set('status','inactive');domLib_detectCollisions(tipObj,true);}}}
function domTT_mouseout(in_owner,in_event)
{if(!domLib_useLibrary){return false;}
if(typeof(in_event)=='undefined')
{in_event=event;}
var toChild=domLib_isDescendantOf(in_event[domLib_eventTo],in_owner);var tooltip=domTT_tooltips.get(in_owner.id);if(tooltip&&(tooltip.get('type')=='greasy'||tooltip.get('status')!='active'))
{if(!toChild)
{domTT_deactivate(in_owner.id);try{window.status=window.defaultStatus;}catch(e){}}}
else if(!toChild)
{try{window.status=window.defaultStatus;}catch(e){}}}
function domTT_mousemove(in_owner,in_event)
{if(!domLib_useLibrary){return false;}
if(typeof(in_event)=='undefined')
{in_event=event;}
var tooltip=domTT_tooltips.get(in_owner.id);if(tooltip&&tooltip.get('trail')&&tooltip.get('status')=='active')
{if(tooltip.get('lazy'))
{domLib_setTimeout(domTT_runShow,domTT_trailDelay,[in_owner.id,in_event]);}
else
{domTT_show(in_owner.id,in_event);}}}
function domTT_addPredefined(in_id)
{var options=new Hash();for(var i=1;i<arguments.length;i+=2)
{options.set(arguments[i],arguments[i+1]);}
domTT_predefined.set(in_id,options);}
function domTT_correctEdgeBleed(in_width,in_height,in_x,in_y,in_offsetX,in_offsetY,in_mouseOffset,in_window)
{var win,doc;var bleedRight,bleedBottom;var pageHeight,pageWidth,pageYOffset,pageXOffset;var x=in_x+in_offsetX;var y=in_y+in_offsetY+in_mouseOffset;win=(typeof(in_window)=='undefined'?window:in_window);doc=((domLib_standardsMode&&(domLib_isIE||domLib_isGecko))?win.document.documentElement:win.document.body);if(domLib_isIE)
{pageHeight=doc.clientHeight;pageWidth=doc.clientWidth;pageYOffset=doc.scrollTop;pageXOffset=doc.scrollLeft;}
else
{pageHeight=doc.clientHeight;pageWidth=doc.clientWidth;if(domLib_isKHTML)
{pageHeight=win.innerHeight;}
pageYOffset=win.pageYOffset;pageXOffset=win.pageXOffset;}
if((bleedRight=(x-pageXOffset)+in_width-(pageWidth-domTT_screenEdgePadding))>0)
{x-=bleedRight;}
if((x-pageXOffset)<domTT_screenEdgePadding)
{x=domTT_screenEdgePadding+pageXOffset;}
if((bleedBottom=(y-pageYOffset)+in_height-(pageHeight-domTT_screenEdgePadding))>0)
{y=in_y-in_height-in_offsetY;}
if((y-pageYOffset)<domTT_screenEdgePadding)
{y=in_y+domTT_mouseHeight+in_offsetY;}
return{'x':x,'y':y};}
function domTT_isActive(in_id)
{var tooltip=domTT_tooltips.get(in_id);if(!tooltip||tooltip.get('status')!='active')
{return false;}
else
{return true;}}
function domTT_runDeactivate(args){domTT_deactivate(args[0]);}
function domTT_runShow(args){domTT_show(args[0],args[1]);}
function domTT_replaceTitles(in_decorator)
{var elements=domLib_getElementsByClass('tooltip');for(var i=0;i<elements.length;i++)
{if(elements[i].title)
{var content;if(typeof(in_decorator)=='function')
{content=in_decorator(elements[i]);}
else
{content=elements[i].title;}
content=content.replace(new RegExp('\'','g'),'\\\'');elements[i].onmouseover=new Function('in_event',"domTT_activate(this, in_event, 'content', '"+content+"')");elements[i].title='';}}}
function domTT_update(handle,content,type)
{if(typeof(type)=='undefined')
{type='content';}
var tip=domTT_tooltips.get(handle);if(!tip)
{return;}
var tipObj=tip.get('node');var updateNode;if(type=='content')
{updateNode=tipObj.firstChild;if(updateNode.className!='contents')
{updateNode=updateNode.firstChild.firstChild.nextSibling.firstChild.firstChild;}}
else
{updateNode=tipObj.firstChild;if(updateNode.className=='contents')
{return;}
updateNode=updateNode.firstChild.firstChild.firstChild.firstChild;}
updateNode.innerHTML=content;}