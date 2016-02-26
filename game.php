<?php //session_start();
//if (isset($_SESSION['USR_LOGIN'])=="") {
	//header("Location:login.php");
//}
include("mytcg/settings.php");
ob_start();
include("$header");
$buffer=ob_get_contents();
ob_end_clean();
if (!$_SERVER['QUERY_STRING']) {
$buffer=str_replace("%TITLE%","Games | Wild Thing",$buffer);
echo $buffer;?>

<?php } elseif ($_SERVER['QUERY_STRING'] == "blackjack") {
$buffer=str_replace("%TITLE%","Playing Blackjack | Wild Thing",$buffer);
echo $buffer; ?>
<h1><a href="/interactive.php?weekly">Weekly Games</a> &gt; Blackjack</h1>
<blockquote>Press "Deal" to begin the game! :) Try to get as close to 21 as you can, and Stand when you think you might go over (or if you have 21). Good luck! You have <strong>3</strong> tries.</blockquote>
<SCRIPT LANGUAGE="JavaScript">
<!-- Original:  Mike McGrath (mike_mcgrath@lineone.net) -->
<!-- Web Site:  http://home.clara.net/mikem  -->

<!-- Begin
var gameOver = 0; var cardCount;
function Shuffle(max){
var num=Math.random()*max;
return Math.round(num)+1;
}
function getSuit(){
suit = Shuffle(4);
if(suit == 1) return "Spades";
if(suit == 2) return "Clubs";
if(suit == 3) return "Diamonds";
else return "Hearts";
}
function cardName(card){
if(card == 1) return "Ace";
if(card == 11) return "Jack";
if(card == 12) return "Queen";
if(card == 13) return "King";
return "" + card;
}
function cardValue(card,strWho){
if(card == 1) {
	if(strWho =="You" && document.display.you.value >10){
	document.display.say2.value=document.display.say2.value+" Low"; return 1;}
	else return 11; }
 if(card > 10) return 10; 
return card;
}
function PickACard(strWho){
card = Shuffle(12);
suit = getSuit();
if(strWho =="You")
document.display.say2.value=(cardName(card) + " of " + suit);
else
document.display.say1.value=(cardName(card) + " of " + suit);
return cardValue(card,strWho);
}
function NewHand(form){
if(gameOver !=0)
{form.say1.value=("Hand in Play!"); form.say2.value=(""); return;}
else
{form.dealer.value = 0; form.you.value = 0; cardCount=0;
form.dealer.value = eval(form.dealer.value) + PickACard("Dealer");
form.you.value = eval(form.you.value) + PickACard("You");
gameOver= -1; cardCount+=1;}
}
function Dealer(form){
if (gameOver ==0)
{form.say1.value=("Deal the Cards!"); form.say2.value=(""); return;}
else
if(form.you.value<10)
{form.say1.value=("Not Below Ten!"); form.say2.value=("Take a Hit!"); return;}
else
if (cardCount <2)
{form.say1.value=("Minimum 2 Cards!"); form.say2.value=("Hit Again!"); return;}
else
while(form.dealer.value < 17)
{form.dealer.value = eval(form.dealer.value) + PickACard("Dealer");}
}
function User(form){
if (gameOver ==0)
{form.say1.value=("Deal the Cards!"); form.say2.value=(""); return;}
else
{cardCount+=1; form.say1.value=("You Get...");
form.you.value = eval(form.you.value) + PickACard("You");}
if(form.you.value > 21)
{form.say1.value=("You Busted!");
gameOver=0; form.numgames.value=eval(form.numgames.value)-1;}
}
function LookAtHands(form){
if (gameOver ==0 || form.you.value<10 || cardCount <2){return;}
else
if(form.dealer.value > 21)
{form.say1.value=("House Busts!"); form.say2.value=("Winner!");  
document.location="reward.php?game=Blackjack";
gameOver=0; form.numgames.value=eval(form.numgames.value)+1;}
 else
if(form.you.value > form.dealer.value)
{form.say1.value=("You Win!"); form.say2.value=("Winner!");  
document.location="reward.php?game=Blackjack";
gameOver=0; form.numgames.value=eval(form.numgames.value)+1;}
 else
 if(form.dealer.value == form.you.value)
{form.say1.value=("Game Tied!"); form.say2.value=("Tied. Give it another go! :D");  
gameOver=0; form.numgames.value=eval(form.numgames.value)-1;}
 else
{form.say1.value=("House Wins!"); form.say2.value=("Try again!");  
gameOver=0; form.numgames.value=eval(form.numgames.value)-1;}
}
function setBj(){
gameOver=0; cardCount=0; 
document.display.dealer.value=""; 
document.display.you.value="";
document.display.numgames.value="0";
document.display.say1.value="    Hit 'Deal'";
document.display.say2.value="    To Start!";
}
// End -->
</script>
<form name="display">
<table align="center" class="wildthing">
<tr>
<th class="center">Score:</th>
<th class="center">Dealer:</th>
<td class="center"><input type=text name="dealer" size="2"></td>
<td class="center">Card(s):  <input type=text name="say1" size="24" value=""></td>
</tr>
<tr>
<td class="center"><input type=text name="numgames" size="3" value="0"></td>
<th class="center">Player</center></th>
<td class="center"><input type=text name="you" size="2"></td>
<td class="center">Card(s):  <input type=text name="say2" size="24" value=""></td>
</tr>
<tr>
<td class="center"><input type=button value="Deal" onClick="NewHand(this.form)"></td>
<td colspan="3" class="center">
<input type=button value="Stand" onClick="Dealer(this.form);LookAtHands(this.form);">
<input type=button value=" Hit " onClick="User(this.form)"></td></tr>
</table>
</form>
<?php } elseif ($_SERVER['QUERY_STRING'] == "card") {
$buffer=str_replace("%TITLE%","Playing Card Puzzle | Wild Thing",$buffer);
echo $buffer; ?>
<h1><a href="/interactive.php?weekly">Weekly Games</a> &gt; Card Puzzle</h1>
<blockquote>Put the puzzle together for a prize. Already solved this one? Refresh the page for a new one.</blockquote>
<script>
		
        const PUZZLE_DIFFICULTY = 4; <!--  Define here the level of your puzzle. In this case is 4x4 -->
        const PUZZLE_HOVER_TINT = '#009900'; <!--Chose the color of the hover tint, to indicate where the piece is going to be placed-->

        var _stage;
        var _canvas;

        var _img;
        var _pieces;
        var _puzzleWidth;
        var _puzzleHeight;
        var _pieceWidth;
        var _pieceHeight;
        var _currentPiece;
        var _currentDropPiece;  

        var _mouse;

        function init(){
            _img = new Image();
            _img.addEventListener('load',onImage,false);
            _img.src = <?php
for($i=1; $i<=1; $i++) {
	$randtype = 'regular';
	echo "\"$tcgcardurl";
	include ("mytcg/random.php"); // put your include to the random generator here. 
	echo ".$ext\"";
}
?>; 
        }
        function onImage(e){
            _pieceWidth = Math.floor(_img.width / PUZZLE_DIFFICULTY)
            _pieceHeight = Math.floor(_img.height / PUZZLE_DIFFICULTY)
            _puzzleWidth = _pieceWidth * PUZZLE_DIFFICULTY;
            _puzzleHeight = _pieceHeight * PUZZLE_DIFFICULTY;
            setCanvas();
            initPuzzle();
        }
        function setCanvas(){
            _canvas = document.getElementById('canvas');
            _stage = _canvas.getContext('2d');
            _canvas.width = _puzzleWidth;
            _canvas.height = _puzzleHeight;
            _canvas.style.border = "1px solid white"; <!--You can change or remove the border of the whole puzzle here-->
        }
        function initPuzzle(){
            _pieces = [];
            _mouse = {x:0,y:0};
            _currentPiece = null;
            _currentDropPiece = null;
            _stage.drawImage(_img, 0, 0, _puzzleWidth, _puzzleHeight, 0, 0, _puzzleWidth, _puzzleHeight);
            createTitle("Click to Start Puzzle");
            buildPieces();
        }
        function createTitle(msg){
            _stage.fillStyle = "#FFFFFF";
            _stage.globalAlpha = .4;
            _stage.fillRect(100,_puzzleHeight - 40,_puzzleWidth - 200,40);
            _stage.fillStyle = "#FFFFFF";
            _stage.globalAlpha = 1;
            _stage.textAlign = "center";
            _stage.textBaseline = "middle";
            _stage.font = "20px Arial";
            _stage.fillText(msg,_puzzleWidth / 2,_puzzleHeight - 20);
        }
        function buildPieces(){
            var i;
            var piece;
            var xPos = 0;
            var yPos = 0;
            for(i = 0;i < PUZZLE_DIFFICULTY * PUZZLE_DIFFICULTY;i++){
                piece = {};
                piece.sx = xPos;
                piece.sy = yPos;
                _pieces.push(piece);
                xPos += _pieceWidth;
                if(xPos >= _puzzleWidth){
                    xPos = 0;
                    yPos += _pieceHeight;
                }
            }
            document.onmousedown = shufflePuzzle;
        }
        function shufflePuzzle(){
            _pieces = shuffleArray(_pieces);
            _stage.clearRect(0,0,_puzzleWidth,_puzzleHeight);
            var i;
            var piece;
            var xPos = 0;
            var yPos = 0;
            for(i = 0;i < _pieces.length;i++){
                piece = _pieces[i];
                piece.xPos = xPos;
                piece.yPos = yPos;
                _stage.drawImage(_img, piece.sx, piece.sy, _pieceWidth, _pieceHeight, xPos, yPos, _pieceWidth, _pieceHeight);
				_stage.strokeStyle = "transparent";  <!--You can change the border of the puzzle PIECES here. Put any color or leave it transparent-->
                _stage.strokeRect(xPos, yPos, _pieceWidth,_pieceHeight);
                xPos += _pieceWidth;
                if(xPos >= _puzzleWidth){
                    xPos = 0;
                    yPos += _pieceHeight;
                }
            }
            document.onmousedown = onPuzzleClick;
        }
        function onPuzzleClick(e){
            if(e.pageX || e.pageX == 0){
                _mouse.x = e.pageX - _canvas.offsetLeft;
                _mouse.y = e.pageY - _canvas.offsetTop;
            }
            else if(e.offsetX || e.offsetX == 0){
                _mouse.x = e.offsetX;
                _mouse.y = e.offsetY;
            }
            _currentPiece = checkPieceClicked();
            if(_currentPiece != null){
                _stage.clearRect(_currentPiece.xPos,_currentPiece.yPos,_pieceWidth,_pieceHeight);
                _stage.save();
                _stage.globalAlpha = .9;
                _stage.drawImage(_img, _currentPiece.sx, _currentPiece.sy, _pieceWidth, _pieceHeight, _mouse.x - (_pieceWidth / 2), _mouse.y - (_pieceHeight / 2), _pieceWidth, _pieceHeight);
                _stage.restore();
                document.onmousemove = updatePuzzle;
                document.onmouseup = pieceDropped;
            }
        }
        function checkPieceClicked(){
            var i;
            var piece;
            for(i = 0;i < _pieces.length;i++){
                piece = _pieces[i];
                if(_mouse.x < piece.xPos || _mouse.x > (piece.xPos + _pieceWidth) || _mouse.y < piece.yPos || _mouse.y > (piece.yPos + _pieceHeight)){
                    //PIECE NOT HIT
                }
                else{
                    return piece;
                }
            }
            return null;
        }
        function updatePuzzle(e){
            _currentDropPiece = null;
            if(e.pageX || e.pageX == 0){
                _mouse.x = e.pageX - _canvas.offsetLeft;
                _mouse.y = e.pageY - _canvas.offsetTop;
            }
            else if(e.offsetX || e.offsetX == 0){
                _mouse.x = e.offsetX;
                _mouse.y = e.offsetY;
            }
            _stage.clearRect(0,0,_puzzleWidth,_puzzleHeight);
            var i;
            var piece;
            for(i = 0;i < _pieces.length;i++){
                piece = _pieces[i];
                if(piece == _currentPiece){
                    continue;
                }
                _stage.drawImage(_img, piece.sx, piece.sy, _pieceWidth, _pieceHeight, piece.xPos, piece.yPos, _pieceWidth, _pieceHeight);
                _stage.strokeRect(piece.xPos, piece.yPos, _pieceWidth,_pieceHeight);
                if(_currentDropPiece == null){
                    if(_mouse.x < piece.xPos || _mouse.x > (piece.xPos + _pieceWidth) || _mouse.y < piece.yPos || _mouse.y > (piece.yPos + _pieceHeight)){
                        //NOT OVER
                    }
                    else{
                        _currentDropPiece = piece;
                        _stage.save();
                        _stage.globalAlpha = .4;
                        _stage.fillStyle = PUZZLE_HOVER_TINT;
                        _stage.fillRect(_currentDropPiece.xPos,_currentDropPiece.yPos,_pieceWidth, _pieceHeight);
                        _stage.restore();
                    }
                }
            }
            _stage.save();
            _stage.globalAlpha = .6;
            _stage.drawImage(_img, _currentPiece.sx, _currentPiece.sy, _pieceWidth, _pieceHeight, _mouse.x - (_pieceWidth / 2), _mouse.y - (_pieceHeight / 2), _pieceWidth, _pieceHeight);
            _stage.restore();
            _stage.strokeRect( _mouse.x - (_pieceWidth / 2), _mouse.y - (_pieceHeight / 2), _pieceWidth,_pieceHeight);
        }
        function pieceDropped(e){
            document.onmousemove = null;
            document.onmouseup = null;
            if(_currentDropPiece != null){
                var tmp = {xPos:_currentPiece.xPos,yPos:_currentPiece.yPos};
                _currentPiece.xPos = _currentDropPiece.xPos;
                _currentPiece.yPos = _currentDropPiece.yPos;
                _currentDropPiece.xPos = tmp.xPos;
                _currentDropPiece.yPos = tmp.yPos;
            }
            resetPuzzleAndCheckWin();
        }
        function resetPuzzleAndCheckWin(){
            _stage.clearRect(0,0,_puzzleWidth,_puzzleHeight);
            var gameWin = true;
            var i;
            var piece;
            for(i = 0;i < _pieces.length;i++){
                piece = _pieces[i];
                _stage.drawImage(_img, piece.sx, piece.sy, _pieceWidth, _pieceHeight, piece.xPos, piece.yPos, _pieceWidth, _pieceHeight);
                _stage.strokeRect(piece.xPos, piece.yPos, _pieceWidth,_pieceHeight);
                if(piece.xPos != piece.sx || piece.yPos != piece.sy){
                    gameWin = false;
                }
            }
            if(gameWin){
                setTimeout(gameOver,500);
            }
        }
        function gameOver(){
            document.onmousedown = null;
            document.onmousemove = null;
            document.onmouseup = null;
			document.location="/reward.php?game=Card Puzzle"; <!--load prize-->
        }
        function shuffleArray(o){
            for(var j, x, i = o.length; i; j = parseInt(Math.random() * i), x = o[--i], o[i] = o[j], o[j] = x);
            return o;
        }
		
		init();
    	</script>
        
        <p class="center"><canvas id="canvas"></canvas></p>
<?php } elseif ($_SERVER['QUERY_STRING'] == "guess") {
$buffer=str_replace("%TITLE%","Playing Guess the Number | Wild Thing",$buffer);
echo $buffer; ?>
<h1><a href="/interactive.php?weekly">Weekly Games</a> &gt; Guess the Number</h1>
<blockquote>Guess a number <strong>between 1 and 500</strong>. Keep playing until you win!</blockquote>
<center>
<SCRIPT LANGUAGE="JavaScript">
<!-- ;
// numberguess is by Lancer - written 4 Jan 1999
// lancer@kp.planet.gen.nz
// alterations for oTCG by http://aspire.ohexcite.net

var guessme=Math.round(Math.random()*(499)+1);
var speech='Guess a number (from 1 to 500)';

function process(mystery) {
var guess=document.forms.guessquiz.guess.value;
var speech='"'+guess+ '" does not make sense to me.';
document.forms.guessquiz.guess.value='';

if (guess==mystery)
{
document.forms.guessquiz.prompt.value='Congratulations! It was '+mystery+'!';
alert ('Congrats!');
speech='';
document.location="/reward.php?game=Guess the Number";
}

if (mystery<guess)
{
speech='Less than '+ guess;
}

if (mystery>guess)
{
speech='Greater than '+ guess;
}

if (guess=='')
{
speech='You didn\'t guess anything!'
}

document.forms.guessquiz.prompt.value=speech; document.forms.guessquiz.guess.focus();

}

// end hide -->
</SCRIPT>

<table width="100%"><tr><td width="50%"><img src="images/games/2brownie.jpg" style="max-width: 100%" alt="" /></td><td>
<FORM onSubmit="" NAME="guessquiz">
<INPUT TYPE="text" NAME="prompt" SIZE="31" MAXLENGTH="40" VALUE="How many brownies?"><br> 
<INPUT TYPE="text" NAME="guess" SIZE="3" MAXLENGTH="3" VALUE="">
<INPUT TYPE="button" VALUE="Guess" onClick='process(guessme)'>
</FORM>
</td></tr></table></center>
<?php } elseif ($_SERVER['QUERY_STRING'] == "hangman") {
$buffer=str_replace("%TITLE%","Playing Hangman | Wild Thing",$buffer);
echo $buffer; ?>
<h1><a href="/interactive.php?weekly">Weekly Games</a> &gt; Hangman</h1>
<blockquote>Can you guess the series of the week? If you cannot on the <strong>first</strong> try, do not try again until next week. Good luck!</blockquote>
<script type="text/javascript">

// HangMan II script- By Chris Fortey (http://www.c-g-f.net/)
// For this and over 400+ free scripts, visit JavaScript Kit- http://www.javascriptkit.com/
// Please keep notice intact

var can_play = true;
var words = new Array("DOCTOR WHO", "STAR TREK", "THE XFILES", "STARGATE ATLANTIS", "FARSCAPE", "AGENTS OF SHIELD", "FIREFLY", "THE TWILIGHT ZONE", "FRINGE", "STARGATE UNIVERSE", "LOST", "ARROW", "HAVEN", "CONTINUUM", "WAREHOUSE THIRTEEN", "THE HUNDRED", "HEROES", "DEFIANCE", "TORCHWOOD", "HEROES REBORN", "HEMLOCK GROVE", "THE JETSONS", "SMALLVILLE", "BLACK MIRROR", "FALLING SKIES", "EXTANT", "DEXTERS LABORATORY", "ORPHAN BLACK", "TERRA NOVA", "THE ORIGINALS", "THE VAMPIRE DIARIES", "THE TOMORROW PEOPLE", "FUTURAMA");
var to_guess = "";
var display_word = "";
var used_letters = "";
var wrong_guesses = 0;


function selectLetter(l)
{
if (can_play == false)
{
return;
}

if (used_letters.indexOf(l) != -1)
{
return;
}
	
used_letters += l;
document.game.usedLetters.value = used_letters;
	
if (to_guess.indexOf(l) != -1)
{
 // correct letter guess
pos = 0;
temp_mask = display_word;


while (to_guess.indexOf(l, pos) != -1)
{
pos = to_guess.indexOf(l, pos);			
end = pos + 1;

start_text = temp_mask.substring(0, pos);
end_text = temp_mask.substring(end, temp_mask.length);

temp_mask = start_text + l + end_text;
pos = end;
}

display_word = temp_mask;
document.game.displayWord.value = display_word;
		
if (display_word.indexOf("#") == -1)
{
// won
alert("you win.");
can_play = false;
document.location="reward.php?game=Hangman";
}
}
else
{
// incortect letter guess
wrong_guesses += 1;
eval("document.hm.src=\"images/interactive/hangman/hm" + wrong_guesses + ".gif\"");
		
if (wrong_guesses == 10)
{
// lost
alert("Sorry, you have lost! Try again next week.");
can_play = false;
}
}
}

function reset()
{
selectWord();
document.game.usedLetters.value = "";
used_letters = "";
wrong_guesses = 0;
document.hm.src="images/interactive/hangman/hmstart.gif";
}

function selectWord()
{
can_play = true;
random_number = Math.round(Math.random() * (words.length - 1));
to_guess = words[random_number];
//document.game.theWord.value = to_guess;
	
// display masked word
masked_word = createMask(to_guess);
document.game.displayWord.value = masked_word;
display_word = masked_word;
}

function createMask(m)
{
mask = "";
word_lenght = m.length;


for (i = 0; i < word_lenght; i ++)
{
mask += "#";
}
return mask;
}

</script>



<center>
<img src="images/interactive/hangman/hmstart.gif" name="hm" height="125" width="75"><p></p>
<form name="game">
<p>Display Word: <input name="displayWord" type="text" width="200"><br>
Used Letters: <input name="usedLetters" type="text"></p>
</form>

<p><a href="javascript:selectLetter('A');">A</a> | 
<a href="javascript:selectLetter('B');">B</a> | 
<a href="javascript:selectLetter('C');">C</a> | 
<a href="javascript:selectLetter('D');">D</a> | 
<a href="javascript:selectLetter('E');">E</a> | 
<a href="javascript:selectLetter('F');">F</a> | 

<a href="javascript:selectLetter('G');">G</a> | 
<a href="javascript:selectLetter('H');">H</a> | 
<a href="javascript:selectLetter('I');">I</a> | 
<a href="javascript:selectLetter('J');">J</a> | 
<a href="javascript:selectLetter('K');">K</a> | 
<a href="javascript:selectLetter('L');">L</a> |

<a href="javascript:selectLetter('M');">M</a> |<br />
<a href="javascript:selectLetter('N');">N</a> | 
<a href="javascript:selectLetter('O');">O</a> | 
<a href="javascript:selectLetter('P');">P</a> | 
<a href="javascript:selectLetter('Q');">Q</a> | 
<a href="javascript:selectLetter('R');">R</a> | 

<a href="javascript:selectLetter('S');">S</a> | 
<a href="javascript:selectLetter('T');">T</a> | 
<a href="javascript:selectLetter('U');">U</a> | 
<a href="javascript:selectLetter('V');">V</a> | 
<a href="javascript:selectLetter('W');">W</a> | 
<a href="javascript:selectLetter('X');">X</a> | 

<a href="javascript:selectLetter('Y');">Y</a> | 
<a href="javascript:selectLetter('Z');">Z</a> |
<a href="javascript:selectLetter(' ');">SPACE</a> |

</p><p><a href="javascript:reset()">Start game / Reset game</a></p></center>
<?php } elseif ($_SERVER['QUERY_STRING'] == "memory") {
$buffer=str_replace("%TITLE%","Playing Memory | Wild Thing",$buffer);
echo $buffer; ?>
<h1><a href="/interactive.php?weekly">Weekly Games</a> &gt; Memory</h1>
<blockquote>Match all the squares to receive a prize!</blockquote>
<script language=JavaScript>
function wellDone() {
  if (timeLeft > 0)
  {
    if (
       confirm(
       'Well done! You took '
       + numMinutes
       + ' minutes and '
       + numSeconds
       + ' seconds to complete the game using '
       + numAttempts
       + ' attempts.')
       )     document.location="/reward.php?game=Memory";
  }   
  else {
    if (
       confirm(
       'Bad luck! You ran out of time, but you managed to get '
	   + numCorrect
	   + ' out of '
	   + numPairs
       + ' pairs right. Do you want to try again?')
       ) location.reload();
   }	   
}
</SCRIPT>
<script language=JavaScript>
var imageWidth = 123;
var imageHeight = 101;
var delay = 0;
var doneAction   = "wellDone();";

var matchingPairs = new Array(
"/cards/ob1-cosima04.png", "/cards/ob1-cosima04.png",
"/cards/hg1-peter04.png", "/cards/hg1-peter04.png",
"/cards/tn-genesis120.png", "/cards/tn-genesis120.png",
"/cards/ang1-cordeliadoyle01.png", "/cards/ang1-cordeliadoyle01.png",
"/cards/iz1-deadair01.png", "/cards/iz1-deadair01.png",
"/cards/chm1-phoebe16.png", "/cards/chm1-phoebe16.png",
"/cards/tw5-creaturesnight10.png", "/cards/tw5-creaturesnight10.png",
"/cards/tsc-pilot20.png", "/cards/tsc-pilot20.png",
"/cards/ob1-alison12.png", "/cards/ob1-alison12.png",
"/cards/thun1-earthskills05.png", "/cards/thun1-earthskills05.png"
);
</script><SCRIPT SRC="/interactive/msquares.js"></SCRIPT>
<center><SCRIPT language=JavaScript>
 drawTimer(99);
 drawTable(5,4);
</SCRIPT></center>
<?php } elseif ($_SERVER['QUERY_STRING'] == "peeptin") {
$buffer=str_replace("%TITLE%","Playing Peeptin | Wild Thing",$buffer);
echo $buffer; ?>
<h1><a href="/interactive.php?weekly">Weekly Games</a> &gt; Peeptin</h1>
<blockquote>Press shuffle to start. Your goal is to arrange all numbers back to its original place in ascending order.</blockquote>
<style>
	.peeptin td, .peeptin {
		border:0;
		padding:0;
		margin:0 auto;
		text-align:center;
		line-height:100%;
	}	
	input {
		line-height:100%;
		border:1px #DFAE74 solid;
	}
</style>
		<script language="javascript">
		var max = 3;
		var score = 0;
		var moves = 0;
		var ex = 3;
		var ey = 3;
		
		function getElement15(form, name) {
			var k;
			var elements = form.elements;
			for (k = 0; k < elements.length; k++) {
				if (elements[k].name == name) return elements[k];
			}
		}
		
		function press15(form, button) {
			name = button.name;
			x = name.substring(0,1);
			y = name.substring(2,3);
			play15(form, (x-1+1), (y-1+1));
		}
		
		function shuffle15(form, num) {
			for (i = 0; i < num; i++) {
				x = Math.floor(Math.random(4) * 4);
				if (x == 0) { toggle15(form, ex, ey, ex + 1, ey); }
				else if (x == 1) { toggle15(form, ex, ey, ex - 1, ey); }
				else if (x == 2) { toggle15(form, ex, ey, ex, ey + 1); }
				else if (x == 3) { toggle15(form, ex, ey, ex, ey - 1); }
			}
		}
		
		function play15(form, x, y) {			
			if (Math.abs(ex - x) + Math.abs(ey - y) == 1) {
				done = toggle15(form, x, y, x+1, y);
				if (!done) { done = toggle15(form, x, y, x-1, y); }
				if (!done) { done = toggle15(form, x, y, x, y+1); }
				if (!done) { done = toggle15(form, x, y, x, y-1);	}
				moves++;
				if (check15(form)) {
					alert('You win with ' + moves + ' moves!');
					document.location="/reward.php?game=Peeptin";
				}
			}
			
		}

		function showrules15() {
			rules = 'The goal of the game is to arrange \n' 
				+ 'the blocks from 1 to 15 in their \n'
				+ 'numeric order. Click a number next to\n'
				+ 'the empty cell to move it into that cell.\n'
				+ 'The game is won when all the numbers\n'
				+ 'are sorted, and the empty square is in the \n'
				+ 'lower-righthand corner.';
			alert(rules);
		}
		
		function resetboard15(form) {
			for (i = 0; i < 4; i++) {
				for (j = 0; j < 4; j++) {
					val = 1 + i + (4*j);
					if (val == 16) {
						getElement15(form,i + '_' + j).value = ' ';
					} else {
						getElement15(form,i + '_' + j).value = val;
					}
				}
			}
			score = 0;
			moves = 0;
			ex = 3;
			ey = 3;
		}
	
		function toggle15(form, x, y, x1, y1) {
			if (x < 0 || y < 0 || x > max || y > max) {
				return false;
			}
			if (x1 < 0 || y1 < 0 || x1 > max || y1 > max) {
				return false;
			}

			name = x + '_' + y;
			button = getElement15(form,name);
			name = x1 + '_' + y1;
			button1 = getElement15(form,name);
			if (button.value == ' ' || button1.value == ' ') {
				tmp = button.value;
				button.value = button1.value;
				button1.value = tmp;
				if (button.value == ' ') {
					ex = x;
					ey = y;
				} else {
					ex = x1;
					ey = y1;
				}
				return true;
			}
			return false;
		}
		
		function check15(form) {
			score = 0;
			for (i = 0; i < 4; i++) {
				for (j = 0; j < 4; j++) {
					val = 1 + i + (4*j);
					if (val < 16) {
						if (getElement15(form,i + '_' + j).value == val) {
							score++;
						}
					}
				}
			}
			return score == 15;
		}
	</script>
	<table align="center" class="wildthing peeptin">
		<form>
		<tr>
			<td><input style="width:30px;height:30px;" type="button" name="0_0" value="1" onclick="press15(this.form, this);"></td>
			<td><input style="width:30px;height:30px;" type="button" name="1_0" value="2" onclick="press15(this.form, this);"></td>
			<td><input style="width:30px;height:30px;" type="button" name="2_0" value="3" onclick="press15(this.form, this);"></td>
			<td><input style="width:30px;height:30px;" type="button" name="3_0" value="4" onclick="press15(this.form, this);"></td>
		</tr>
		<tr>
			<td><input style="width:30px;height:30px;" type="button" name="0_1" value="5" onclick="press15(this.form, this);"></td>
			<td><input style="width:30px;height:30px;" type="button" name="1_1" value="6" onclick="press15(this.form, this);"></td>
			<td><input style="width:30px;height:30px;" type="button" name="2_1" value="7" onclick="press15(this.form, this);"></td>
			<td><input style="width:30px;height:30px;" type="button" name="3_1" value="8" onclick="press15(this.form, this);"></td>
		</tr>
		<tr>
			<td><input style="width:30px;height:30px;" type="button" name="0_2" value="9" onclick="press15(this.form, this);"></td>
			<td><input style="width:30px;height:30px;" type="button" name="1_2" value="10" onclick="press15(this.form, this);"></td>
			<td><input style="width:30px;height:30px;" type="button" name="2_2" value="11" onclick="press15(this.form, this);"></td>
			<td><input style="width:30px;height:30px;" type="button" name="3_2" value="12" onclick="press15(this.form, this);"></td>
		</tr>
		<tr>
			<td><input style="width:30px;height:30px;" type="button" name="0_3" value="13" onclick="press15(this.form, this);"></td>
			<td><input style="width:30px;height:30px;" type="button" name="1_3" value="14" onclick="press15(this.form, this);"></td>
			<td><input style="width:30px;height:30px;" type="button" name="2_3" value="15" onclick="press15(this.form, this);"></td>
			<td><input style="width:30px;height:30px;" type="button" name="3_3" value=" " onclick="press15(this.form, this);"></td>
		</tr>
		<tr>
			<td colspan="2">
				<input style="width:70px;height:30px;" type="button" value="reset" onclick="resetboard15(this.form);">
			</td>
			<td colspan="2">
				<input style="width:70px;height:30px;" type="button" value="rules" onclick="showrules15();">
			</td>
		</tr>
		<tr>
			<td colspan="4">
				<input style="width:150px;height:30px;" type="button" value="shuffle" onclick="shuffle15(this.form,150);">
			</td>
		</tr>
		</form>
		</table>
<?php } elseif ($_SERVER['QUERY_STRING'] == "pick") {
$buffer=str_replace("%TITLE%","Playing Pick a Monster | Wild Thing",$buffer);
echo $buffer; ?>
<h1><a href="/interactive.php?weekly">Weekly Games</a> &gt; War</h1>
<blockquote>If your card is greater than the Grounders', you win a prize! If not, try again next week.</blockquote>
<?php } elseif ($_SERVER['QUERY_STRING'] == "slots") {
$buffer=str_replace("%TITLE%","Playing Slots | Wild Thing",$buffer);
echo $buffer; ?>
<h1><a href="/interactive.php?weekly">Weekly Games</a> &gt; Slots</h1>
<blockquote>Refresh your browser until two images match.</blockquote>
<p class="center"><?php

$slots = array (
"/images/covers/sets/Agent Carter.png",
"/images/covers/sets/Hemlock Grove.png",
"/images/covers/sets/iZombie.png",
"/images/covers/sets/Orphan Black.png",
"/images/covers/sets/Sleepy Hollow.png",
);

$one= $slots[array_rand($slots,1)];
$two= $slots[array_rand($slots,1)];

echo "<img src=\"" . $one ."\">\n";
echo "<img src=\"" . $two ."\">\n";
echo "</p>\n";


if ($one==$two) { ?>
<script type="text/javascript">
<!--
function delayer(){
    window.location = "/reward.php?game=Slots"
}
//-->
</script>
<body onLoad="setTimeout('delayer()', 3000)">
<?php
	echo "<h2>Redirecting&hellip;</h2>Forwarding you to the rewards page&hellip;";
}

?>
<?php } elseif ($_SERVER['QUERY_STRING'] == "tictactoe") {
$buffer=str_replace("%TITLE%","Playing Tic-Tac-Toe | Wild Thing",$buffer);
echo $buffer; ?>
<h1><a href="/interactive.php?weekly">Weekly Games</a> &gt; War</h1>
<blockquote>If your card is greater than the Grounders', you win a prize! If not, try again next week.</blockquote>
<?php } elseif ($_SERVER['QUERY_STRING'] == "wheel") {
$buffer=str_replace("%TITLE%","Playing Wheel of Surprises | Wild Thing",$buffer);
echo $buffer; ?>
<h1><a href="/interactive.php?weekly">Weekly Games</a> &gt; Wheel of Surprises</h1>
<blockquote>Take a chance and spin the wheel for a prize! Everbody wiwns!</blockquote>
<script>
/*
Wheel of links script
By JavaScript Kit  http://javascriptkit.com)
Over 200+ free scripts here!
*/
var count=0
function dothis(){
setTimeout("document.wheel.wheel2.selectedIndex =1000",100)
setTimeout("document.wheel.wheel2.selectedIndex =count",200)
setTimeout("document.wheel.wheel2.selectedIndex =1000",300)
setTimeout("document.wheel.wheel2.selectedIndex =count",400)
setTimeout("document.wheel.wheel2.selectedIndex =1000",500)
setTimeout("document.wheel.wheel2.selectedIndex =count",600)
setTimeout("window.location=document.wheel.wheel2.options[document.wheel.wheel2.selectedIndex].value",800)
}
function animate(){
var countfinal=Math.round(Math.random()*(document.wheel.wheel2.length-1))
document.wheel.wheel2.selectedIndex =count
if (count==countfinal){
dothis()
return
}
if (count<document.wheel.wheel2.length)
count++
else
count=0
setTimeout("animate()",50)
} 
</script>
<script>
<!--
/*
Random link button- By JavaScript Kit (http://javascriptkit.com)
Over 300+ free scripts!
This credit MUST stay intact for use
*/

//specify random links below. You can have as many as you want
var randomlinks=new Array()

randomlinks[0]="?a"
randomlinks[1]="?b"
randomlinks[2]="?c"
randomlinks[3]="?d"
randomlinks[4]="?e"
randomlinks[5]="?f"
randomlinks[6]="?g"
randomlinks[7]="?h"

function randomlink(){
window.location=randomlinks[Math.floor(Math.random()*randomlinks.length)]
}
//-->
</script>

<form method="POST" name="wheel">
<p class="center"><select name="wheel2" size="6">
    <option value="reward_type.php?type=1&game=Wheel of Surprises">Characters</option>
    <option value="reward_type.php?type=2&game=Wheel of Surprises">Episodes</option>
    <option value="reward_type.php?type=3&game=Wheel of Surprises">Relationships</option>
    <option value="reward.php?game=Wheel of Surprisees (Random)">Random</option>
</select></p>
<p class="center"><input type="button" value="Spin wheel!" name="B1" onClick="animate()"></p></form>
<?php } elseif ($_SERVER['QUERY_STRING'] == "war") {
$buffer=str_replace("%TITLE%","Playing War | Wild Thing",$buffer);
echo $buffer; ?>
<h1><a href="/interactive.php?weekly">Weekly Games</a> &gt; War</h1>
<blockquote>If your card is greater than the Grounders', you win a prize! If not, try again next week.</blockquote>
<?php
$result=mysql_query("SELECT * FROM `$table_cards` WHERE `worth`='1'") or die("Unable to select from database.");
$min=1;
$max=mysql_num_rows($result);
for($i=0; $i<1; $i++) {
mysql_data_seek($result,rand($min,$max)-1);
$row=mysql_fetch_assoc($result);
$digits = rand(01,$row['count']);
if ($digits < 10) { $_digits = "0$digits"; } else { $_digits = $digits;}
$computer = "$row[filename]$_digits";
}
$result3=mysql_query("SELECT * FROM `$table_cards` WHERE `worth`='1'") or die("Unable to select from database.");
$min=1;
$max=mysql_num_rows($result);
for($i=0; $i<1; $i++) {
mysql_data_seek($result3,rand($min,$max)-1);
$row3=mysql_fetch_assoc($result3);
$digits3 = rand(01,$row3['count']);
if ($digits3 < 10) { $_digits3 = "0$digits3"; } else { $_digits3 = $digits3;}
$you = "$row3[filename]$_digits3";
}
?>
<table align="center" width="20%">
<tr><th class="center">Grounders</th><th class="center">Delinquents</th></tr>
<tr><td><?php echo "<img src=\"$tcgcardurl$computer.png\" border=\"0\" /> "; ?></td><td><?php echo "<img src=\"$tcgcardurl$you.png\" border=\"0\" /> "; ?></td></tr>
</table>
<? if ($digits3 <= $digits) { ?><h2>Sorry!</h2>
You didn't win this round. Please try again next week.<? } ?>
<? if ($digits3 > $digits) { ?>
<h2>Congrats!</h2>
Collect your reward below.
<p><?php
$result2=mysql_query("SELECT * FROM `$table_cards` WHERE `worth`='1'") or die("Unable to select from database.");
$min=1;
$max=mysql_num_rows($result);
for($i=0; $i<rand(2,3); $i++) {
mysql_data_seek($result2,rand($min,$max)-1);
$row2=mysql_fetch_assoc($result2);
$digits2 = rand(01,$row2['count']);
if ($digits2 < 10) { $_digits2 = "0$digits2"; } else { $_digits2 = $digits2;}
$card = "$row2[filename]$_digits2";
echo "<img src=\"$tcgcardurl$card.png\" border=\"0\" /> ";
$rewards .= $card.", ";
}
$rewards = substr_replace($rewards,"",-2);
echo "<br /><strong>War:</strong> $rewards";
}
?></p>

<?php }
include("$footer"); ?>