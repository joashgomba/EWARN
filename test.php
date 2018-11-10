
<script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>

<script type="text/javascript">
    function nicCount(editor, ctrId, maxChars)  {
        // Count characters remaining in the given nicEditor (editor), and update the given counter (ctrId)
        counterObj = document.getElementById(ctrId);
        if(counterObj) {
            var content = editor.getContent();
            if(maxChars - content.length <= 0) {
                // if there are no characters remaining, display the negative count in red
                counterObj.innerHTML = "<font color='red'>"+ (maxChars - content.length) + "</font>";
            }
            else { // characters remaining
                counterObj.innerHTML = maxChars - content.length;
            }
        }
    }
 </script>

<script type="text/javascript">
    //<[!CDATA[
    bkLib.onDomLoaded (function() {
        var editor = nicEditors.findEditor('area1');
        editor.getElm().onkeyup = function() { nicCount(editor, 'mycounter1', 50); }
    })
    //]]
</script>

<textarea name="area1" id="area1" cols="40" rows="10" maxlength="50"><br /></textarea>

<p><b id='mycounter1'>50</b> characters remaining</p>