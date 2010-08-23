<HTML>
<HEAD>
<STYLE type="text/css">
<!--
.hidden { position: relative;
     visibility: hidden
     }

.overflow { position: absolute;
     top: 210px;
     left: 60px;
     width: 40px;
     height: 40px;
     background-color: yellow;
     overflow: hidden
     }

.plain { position: absolute;
     top: 200px;
     left: 200px;
     width: 150px;
     height: 150px;
     background-color: #eeeeee;
     }

.clip { position: absolute;
     top: 200px;
     left: 200px;
     width: 150px;
     height: 150px;
     color: yellow;
     background-color: blue;
     clip: rect(25px 125px 125px 25px);
     }
-->
</STYLE>
</HEAD>
<BODY>
<SPAN class="hidden">This text is invisible on the page,</SPAN>
but this text is affected by the invisible item's flow.

<DIV class="overflow">This is way too much text for the little box that we've designated. The overflow property will hide it.</DIV>

<DIV class="plain">This text is covered by the blue square that follows. But because the square is clipped, some of this text shows through.</DIV>

<DIV class="clip">This text is yellow on a blue square, but it's getting cut off by clipping.</DIV>

</BODY>
</HTML> 