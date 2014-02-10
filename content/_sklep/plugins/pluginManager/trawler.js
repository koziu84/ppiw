/**
* Recursively searches for a <TAG> node (note the case!), optionally with attribute <att>=<attVal> and to a specified level of child nodes
* @return object node or false if not found
* @param object starting node
* @param string tag to search for (uppercase!)
* @param string optional attribute name to search for (lowercase!)
* @param string optional attribute value
* @param integer number of child levels to search through (0 = just this level, default is all)
* @param integer current level (recursive use only)
*/
function trawlDOM(obj,tag,att,attVal,children,thisChild){
  var attIE = (att=='class')?'className':att; //IE defines the 'class' attribute as'className'!
  if(children==null){ children=999; }
  if(thisChild==null){ thisChild=0; }
  var tgt=(obj.nodeName==tag && (!att || obj.getAttribute(att) || obj.getAttribute(attIE)) && (!att || !attVal || obj.getAttribute(att)==attVal || obj.getAttribute(attIE)==attVal))?obj:false;
  if(!tgt && obj.nodeType==1 && obj.hasChildNodes() && children>thisChild){ tgt=trawlDOM(obj.firstChild,tag,att,attVal,children,(thisChild+1)); }
  while(!tgt && obj.nextSibling){
    obj=obj.nextSibling;
    if(obj.nodeName==tag && (!att || obj.getAttribute(att) || obj.getAttribute(attIE)) && (!att || !attVal || obj.getAttribute(att)==attVal || obj.getAttribute(attIE)==attVal)){ tgt=obj; }
    if(!tgt && obj.nodeType==1 && obj.hasChildNodes() && children>thisChild){ tgt=trawlDOM(obj.firstChild,tag,att,attVal,children,(thisChild+1)); } }
  return tgt;
} // end function trawlDOM

