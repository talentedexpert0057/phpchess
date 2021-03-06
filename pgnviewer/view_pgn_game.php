<?php

////////////////////////////////////////////////////////////////////////////////
//
// COPYRIGHT NOTICE 
// Copyright 2005 PHPChess (c) All rights reserved. 
// PHPChess, http://www.phpchess.com
//
////////////////////////////////////////////////////////////////////////////////

  define('CHECK_PHPCHESS', true);

  $Root_Path = "../";
  $config = $Root_Path."bin/config.php";

/////// 

  require($Root_Path."bin/CSkins.php");
  
  //Instantiate the CSkins Class
  $oSkins = new CSkins($config);
  $SkinName = $oSkins->getskinname();
  $oSkins->Close();
  unset($oSkins);
///////

  require($Root_Path."bin/CR3DCQuery.php");

  $gameid = $_GET['gameid'];

  $PGN = "";
  $FEN = "";


  if($gameid != ""){

    // Get the pgn text
    //Instantiate the CR3DCQuery Class
    $oR3DCQuery = new CR3DCQuery($config);
    $PGN = $oR3DCQuery->SavePGN2($config, $gameid);
    $FEN = $oR3DCQuery->FormatInputedFEN2($oR3DCQuery->GetInitialGameFEN($config, $gameid)); //replaceLast($oR3DCQuery->GetHackedFEN($sid, $gameid), "0", "1");
    $oR3DCQuery->Close();
    unset($oR3DCQuery);

  }else{
    $FEN = "rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0 1";
  }

   function replaceLast($string, $search, $replace) {
       
       $pos = false;
       
       if (is_int(strpos($string, $search))) {
           $endPos = strlen($string);
           while ($endPos > 0) {
               $endPos = $endPos - 1;
               $pos = strpos($string, $search, $endPos);
               if (is_int($pos)) {
                   break;
               }
           } 
       }
       
       if (is_int($pos)) {
           $len = strlen($search);
           return substr_replace($string, $replace, $pos, $len);
       }
       
       return $string;
   }


//echo $FEN."<br>--";
?>
<html>
<head>
<title>View/Play PGN Game</title>
<link rel="stylesheet" href="<?php echo $Root_Path."skins/".$SkinName;?>/layout.css" type="text/css">

<script language='javascript'>
var FenString = "<?php echo $FEN; ?>";   
</script>
<?php //"rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0 1"; ?>
<script language="JavaScript" src="ltpgnviewer.js"></script>
</head>
<body>


<!-- oooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooo -->

<table noborder cellpadding=0 cellspacing=0><tr><td>
<FORM name=BoardForm>

<table noborder>
<tr><td width=100% align=left><nobr>Url:
<input type=text name="Url" value="" size=32 class='post'>
<input type=button class='mainoption' value=" Open " onClick="javascript:OpenUrl('')">
<input type="checkbox" name="OpenParsePgn">parse pgn</nobr></td></tr></table>

<table border=0><tr><td>
<script language="JavaScript">
//SetImagePath("alpha30/");//use this function when your images are in another directory
EvalUrlString("SetImagePath");
ImageOffset=document.images.length;
var ii, ll=new Array(
"br","bn","bb","bq","bk","bb","bn","br",
"bp","bp","bp","bp","bp","bp","bp","bp",
"t","t","t","t","t","t","t","t",
"t","t","t","t","t","t","t","t",
"t","t","t","t","t","t","t","t",
"t","t","t","t","t","t","t","t",
"wp","wp","wp","wp","wp","wp","wp","wp",
"wr","wn","wb","wq","wk","wb","wn","wr");
var ImageStyle="";
if (ImagePath!="") SetBorder(0);
EvalUrlString("SetBorder");
if (Border)
{ if (document.layers) ImageStyle="border=1 ";
  else ImageStyle="style='border-width:"+Border+"px; border-style:solid; border-color:#404040;' ";
}
document.writeln("<table border=0 cellpadding=1 cellspacing=0><tr><td bgcolor=#404040>");
if (!document.layers) document.writeln("<div id='Board'>");
document.write("<TABLE border=0 cellpadding=0 cellspacing=0><TR>");
for (ii=0; ii<64; ii++)
{ if ((9*ii-ii%8)%16==0) document.write("<TD background='"+ImagePath+"w.gif'>");
  else document.write("<TD background='"+ImagePath+"b.gif'>");
  document.write("<IMG SRC='"+ImagePath+ll[ii]+".gif' "+ImageStyle+" id='"+ii+"' onMouseDown='BoardClick("+ii+")'></TD>");
  if (ii%8==7)
  { if (ii<63) document.write("</TR><TR>");
    else
    { document.writeln("</TR></TABLE>");
      if (!document.layers) document.writeln("</div><div id='Canvas' style='position:relative;z-index:100'></div>");
    }
  }    
}
document.writeln("</td><th><img name='RightLabels' src='"+ImagePath+"8_1.gif' onMouseDown='RotateBoard(! isRotated)' title='rotate board' alt='rotate board'></th></tr>");
document.writeln("<tr><th><img name='BottomLabels' src='"+ImagePath+"a_h.gif' onMouseDown='SetDragDrop(! isDragDrop)' title='piece animation on/off' alt='piece animation on/off'></th>");
document.writeln("<th><img src='"+ImagePath+"1x1.gif' width=7 height=7 border=1 onMouseDown='SwitchLabels()' title='show/hide labels' alt='show/hide labels'></th></tr></table>");
</script>

<TABLE noborder cellpadding=1 cellspacing=0><TR>
<TD><input type=button class='mainoption' value="I&lt;" width=20 style="width:24" id="btnInit" onClick="javascript:Init('')"></TD>
<TD><input type=button class='mainoption' value="&lt;&lt;" width=20 style="width:24" id="btnMB10" onClick="javascript:MoveBack(10)"></TD>
<TD><input type=button class='mainoption' value="&lt;" width=20 style="width:24" id="btnMB1" onClick="javascript:MoveBack(1)"></TD>
<TD><input type=button class='mainoption' value="&gt;" width=20 style="width:24" id="btnMF1" onClick="javascript:MoveForward(1)"></TD>
<TD><input type=button class='mainoption' value="&gt;&gt;" width=20 style="width:24" id="btnMF10" onClick="javascript:MoveForward(10)"></TD>
<TD><input type=button class='mainoption' value="&gt;I" width=20 style="width:24" id="btnMF1000" onClick="javascript:MoveForward(1000)"></TD>
<TD><input type=button class='mainoption' value="play" width=40 style="width:41" id="btnPlay" name="AutoPlay" onClick="javascript:SwitchAutoPlay()"></TD>
<TD><select name="Delay" onChange="SetDelay(this.options[selectedIndex].value)" SIZE=1>
<option value=1000>fast
<option value=2000>med.
<option value=3000>slow
</select>
</TD></TR></TABLE>
<BR>
<NOBR>Position after: <input type=text name="Position" value="" size=16 class='post'></NOBR>

<BR><BR>
<NOBR>
<input type=checkbox name="Rotated" value=1 onClick="javascript:RotateBoard(this.checked)">rotate board 
<input type=checkbox name="Recording" value=1 onClick="javascript:AllowRecording(this.checked)">allow recording
<input type=button class='mainoption' value="undo" title="undo recorded moves" width=38 style="width:39" name="Undo" onClick="javascript:MoveBack(RecordCount)">
</NOBR>

<BR><BR>
<NOBR>
SAN letters: <input type=text name="SAN" value="KQRBNP" size=7 class='post'>
<input type=button class='mainoption' value=" Apply " onClick="javascript:ApplySAN(document.BoardForm.SAN.value)">
</NOBR>
</td>
<td valign='top'>
<textarea name="PgnMoveText" rows=23 cols=30 wrap=virtual class='post'><?php echo $PGN;?></textarea>

</td>
</tr></table>

<BR>
<table noborder width=420>
<tr><td width=100% align=left><NOBR>FEN:
<input type=text class='post' name="FEN" value="<?php echo $FEN;?>" size=31>
<input type=button class='mainoption' value="Apply" onClick="javascript:ApplyFEN(document.BoardForm.FEN.value); Init('');">
<input type=button class='mainoption' value="Get" onClick="javascript:GetFEN()">
<input type=button class='mainoption' value="List" onClick="javascript:alert(GetFENList())">
</NOBR></td></tr></table>
<BR>
<table noborder width=420>
<tr><td width=100% align=left>
<input type=button class='mainoption' value="Setup Board" name="SetupBoard" onClick="javascript:SwitchSetupBoard()">
<input type=radio checked value="copy" name="BoardSetupMode" onClick="javascript:SetBoardSetupMode('copy')">copy
<input type=radio value="move" name="BoardSetupMode" onClick="javascript:SetBoardSetupMode('move')">move
<input type=radio value="delete" name="BoardSetupMode" onClick="javascript:SetBoardSetupMode('delete')">delete
</td></tr></table>

</FORM>
<script language="JavaScript">
Init('');
//EvalUrlString();
if ((ImagePath)&&(document.getElementById)) //adjust button size
{ var ii, nn=0, ss=0;
  for (ii=0; ii<ImagePath.length; ii++)
  { if (isNaN(ImagePath.charAt(ii))) nn=0;
    else { nn*=10; nn+=parseInt(ImagePath.charAt(ii)); ss=nn; }
  }
  if (ss>0)
  { if (ss>27) ss-=8;
    else ss=19;   
    document.getElementById("btnInit").style.width=ss+"px";
    document.getElementById("btnMB10").style.width=ss+"px";
    document.getElementById("btnMB1").style.width=ss+"px";
    document.getElementById("btnMF1").style.width=ss+"px";
    document.getElementById("btnMF10").style.width=ss+"px";
    document.getElementById("btnMF1000").style.width=ss+"px";
    document.getElementById("btnPlay").style.width=eval(2*ss-7)+"px";
  }
}
if (document.layers) setTimeout("RefreshBoard(true)",100);//for the old Netscape 4.7

document.BoardForm.FEN.value = "<?php echo $FEN;?>";
ApplyFEN(document.BoardForm.FEN.value); 
Init('');

</script>
</td></tr></table>

<!-- oooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooo -->

</body>
</html>
