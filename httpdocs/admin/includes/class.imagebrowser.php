<?php
//-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
// MODULE: Classe ImageBrowser
//-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
// Auteur: PascalZ (www.pascalz.com)
//----------------------------------
// Note: Les images intégrées ont été créées avec :
// Img2Php -> http://download.pascalz.com/img2php.exe									
//-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-

if (isset($_GET['GetImage']))
{
	// Image vierge
	if ($_GET['GetImage'] == 'blank')
	{
		header ("Content-type: image/png");
		$im = @imageCreateTrueColor($_GET['w'],$_GET['h'])
			or die ("Impossible de créer une image...");
		$c = substr(urldecode($_GET['bgc']),1);
		$bgcolor = @imagecolorallocate(
				$im,
                (HexDec($c) & 0xFF0000) >> 16,
                (HexDec($c) & 0x00FF00) >>  8,
                (HexDec($c) & 0x0000FF)
                );
		@imagefill($im,0,0,$bgcolor);
		@imagepng($im);
		@ImageDestroy($im);
		exit;
	}
	// bouton précédent grisé
	elseif ($_GET['GetImage'] == 'prevdis')
	{
		header ("Content-type: image/png");

		$width  = 22;
		$height = 103;

		$testGD = get_extension_funcs("gd");
		if (!$testGD)
		{
			echo "<table width=\"22\" height=\"103\" border=\"1\">";
			echo "<tr><td>GD is not installed</td></tr>";
			echo "</table>";
			exit();
		}

		if (in_array ("imagecreatetruecolor",$testGD))
			$im = imagecreatetruecolor($width,$height);
		else $im = imagecreate($width,$height);

		// Palette creation
		$pal[0] = imagecolorallocate ($im, 255, 255, 255);
		$pal[1] = imagecolorallocate ($im, 253, 253, 253);
		$pal[2] = imagecolorallocate ($im, 254, 254, 254);
		$pal[3] = imagecolorallocate ($im, 252, 252, 252);
		$pal[4] = imagecolorallocate ($im, 251, 251, 251);
		$pal[5] = imagecolorallocate ($im, 248, 248, 248);
		$pal[6] = imagecolorallocate ($im, 250, 250, 250);
		$pal[7] = imagecolorallocate ($im, 229, 229, 229);
		$pal[8] = imagecolorallocate ($im, 230, 230, 230);
		$pal[9] = imagecolorallocate ($im, 228, 228, 228);
		$pal[10] = imagecolorallocate ($im, 232, 232, 232);
		$pal[11] = imagecolorallocate ($im, 241, 241, 241);
		$pal[12] = imagecolorallocate ($im, 242, 242, 242);
		$pal[13] = imagecolorallocate ($im, 246, 246, 246);
		$pal[14] = imagecolorallocate ($im, 247, 247, 247);
		$pal[15] = imagecolorallocate ($im, 237, 237, 237);
		$pal[16] = imagecolorallocate ($im, 231, 231, 231);
		$pal[17] = imagecolorallocate ($im, 234, 234, 234);
		$pal[18] = imagecolorallocate ($im, 245, 245, 245);
		$pal[19] = imagecolorallocate ($im, 225, 225, 225);
		$pal[20] = imagecolorallocate ($im, 233, 233, 233);
		$pal[21] = imagecolorallocate ($im, 226, 226, 226);
		$pal[22] = imagecolorallocate ($im, 239, 239, 239);
		$pal[23] = imagecolorallocate ($im, 244, 244, 244);
		$pal[24] = imagecolorallocate ($im, 235, 235, 235);
		$pal[25] = imagecolorallocate ($im, 227, 227, 227);
		$pal[26] = imagecolorallocate ($im, 224, 224, 224);
		$pal[27] = imagecolorallocate ($im, 238, 238, 238);
		$pal[28] = imagecolorallocate ($im, 218, 218, 218);
		$pal[29] = imagecolorallocate ($im, 222, 222, 222);
		$pal[30] = imagecolorallocate ($im, 214, 214, 214);
		$pal[31] = imagecolorallocate ($im, 203, 203, 203);
		$pal[32] = imagecolorallocate ($im, 197, 197, 197);
		$pal[33] = imagecolorallocate ($im, 194, 194, 194);
		$pal[34] = imagecolorallocate ($im, 191, 191, 191);
		$pal[35] = imagecolorallocate ($im, 209, 209, 209);
		$pal[36] = imagecolorallocate ($im, 243, 243, 243);
		$pal[37] = imagecolorallocate ($im, 220, 220, 220);
		$pal[38] = imagecolorallocate ($im, 192, 192, 192);
		$pal[39] = imagecolorallocate ($im, 213, 213, 213);
		$pal[40] = imagecolorallocate ($im, 190, 190, 190);
		$pal[41] = imagecolorallocate ($im, 202, 202, 202);
		$pal[42] = imagecolorallocate ($im, 196, 196, 196);
		$pal[43] = imagecolorallocate ($im, 186, 186, 186);
		$pal[44] = imagecolorallocate ($im, 188, 188, 188);
		$pal[45] = imagecolorallocate ($im, 201, 201, 201);
		$pal[46] = imagecolorallocate ($im, 217, 217, 217);
		$pal[47] = imagecolorallocate ($im, 166, 166, 166);
		$pal[48] = imagecolorallocate ($im, 125, 125, 125);
		$pal[49] = imagecolorallocate ($im, 81, 81, 81);
		$pal[50] = imagecolorallocate ($im, 72, 72, 72);
		$pal[51] = imagecolorallocate ($im, 76, 76, 76);
		$pal[52] = imagecolorallocate ($im, 75, 75, 75);
		$pal[53] = imagecolorallocate ($im, 59, 59, 59);
		$pal[54] = imagecolorallocate ($im, 43, 43, 43);
		$pal[55] = imagecolorallocate ($im, 46, 46, 46);
		$pal[56] = imagecolorallocate ($im, 50, 50, 50);
		$pal[57] = imagecolorallocate ($im, 48, 48, 48);
		$pal[58] = imagecolorallocate ($im, 42, 42, 42);
		$pal[59] = imagecolorallocate ($im, 63, 63, 63);
		$pal[60] = imagecolorallocate ($im, 77, 77, 77);
		$pal[61] = imagecolorallocate ($im, 141, 141, 141);
		$pal[62] = imagecolorallocate ($im, 175, 175, 175);
		$pal[63] = imagecolorallocate ($im, 110, 110, 110);
		$pal[64] = imagecolorallocate ($im, 47, 47, 47);
		$pal[65] = imagecolorallocate ($im, 51, 51, 51);
		$pal[66] = imagecolorallocate ($im, 55, 55, 55);
		$pal[67] = imagecolorallocate ($im, 53, 53, 53);
		$pal[68] = imagecolorallocate ($im, 52, 52, 52);
		$pal[69] = imagecolorallocate ($im, 56, 56, 56);
		$pal[70] = imagecolorallocate ($im, 69, 69, 69);
		$pal[71] = imagecolorallocate ($im, 74, 74, 74);
		$pal[72] = imagecolorallocate ($im, 82, 82, 82);
		$pal[73] = imagecolorallocate ($im, 111, 111, 111);
		$pal[74] = imagecolorallocate ($im, 189, 189, 189);
		$pal[75] = imagecolorallocate ($im, 193, 193, 193);
		$pal[76] = imagecolorallocate ($im, 118, 118, 118);
		$pal[77] = imagecolorallocate ($im, 10, 10, 10);
		$pal[78] = imagecolorallocate ($im, 0, 0, 0);
		$pal[79] = imagecolorallocate ($im, 9, 9, 9);
		$pal[80] = imagecolorallocate ($im, 7, 7, 7);
		$pal[81] = imagecolorallocate ($im, 3, 3, 3);
		$pal[82] = imagecolorallocate ($im, 2, 2, 2);
		$pal[83] = imagecolorallocate ($im, 4, 4, 4);
		$pal[84] = imagecolorallocate ($im, 8, 8, 8);
		$pal[85] = imagecolorallocate ($im, 11, 11, 11);
		$pal[86] = imagecolorallocate ($im, 5, 5, 5);
		$pal[87] = imagecolorallocate ($im, 85, 85, 85);
		$pal[88] = imagecolorallocate ($im, 240, 240, 240);
		$pal[89] = imagecolorallocate ($im, 18, 18, 18);
		$pal[90] = imagecolorallocate ($im, 1, 1, 1);
		$pal[91] = imagecolorallocate ($im, 14, 14, 14);
		$pal[92] = imagecolorallocate ($im, 13, 13, 13);
		$pal[93] = imagecolorallocate ($im, 31, 31, 31);
		$pal[94] = imagecolorallocate ($im, 30, 30, 30);
		$pal[95] = imagecolorallocate ($im, 34, 34, 34);
		$pal[96] = imagecolorallocate ($im, 33, 33, 33);
		$pal[97] = imagecolorallocate ($im, 28, 28, 28);
		$pal[98] = imagecolorallocate ($im, 27, 27, 27);
		$pal[99] = imagecolorallocate ($im, 35, 35, 35);
		$pal[100] = imagecolorallocate ($im, 25, 25, 25);
		$pal[101] = imagecolorallocate ($im, 16, 16, 16);
		$pal[102] = imagecolorallocate ($im, 24, 24, 24);
		$pal[103] = imagecolorallocate ($im, 151, 151, 151);
		$pal[104] = imagecolorallocate ($im, 184, 184, 184);
		$pal[105] = imagecolorallocate ($im, 37, 37, 37);
		$pal[106] = imagecolorallocate ($im, 21, 21, 21);
		$pal[107] = imagecolorallocate ($im, 29, 29, 29);
		$pal[108] = imagecolorallocate ($im, 26, 26, 26);
		$pal[109] = imagecolorallocate ($im, 23, 23, 23);
		$pal[110] = imagecolorallocate ($im, 216, 216, 216);
		$pal[111] = imagecolorallocate ($im, 176, 176, 176);
		$pal[112] = imagecolorallocate ($im, 38, 38, 38);
		$pal[113] = imagecolorallocate ($im, 195, 195, 195);
		$pal[114] = imagecolorallocate ($im, 199, 199, 199);
		$pal[115] = imagecolorallocate ($im, 154, 154, 154);
		$pal[116] = imagecolorallocate ($im, 15, 15, 15);
		$pal[117] = imagecolorallocate ($im, 182, 182, 182);
		$pal[118] = imagecolorallocate ($im, 88, 88, 88);
		$pal[119] = imagecolorallocate ($im, 39, 39, 39);
		$pal[120] = imagecolorallocate ($im, 40, 40, 40);
		$pal[121] = imagecolorallocate ($im, 64, 64, 64);
		$pal[122] = imagecolorallocate ($im, 41, 41, 41);
		$pal[123] = imagecolorallocate ($im, 112, 112, 112);

		// Array of palette indice filling 
		$picture = array (
		0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 2, 2, 2, 2, 2, 3, 1, 2, 2, 1, 1, 2, 0, 3, 1, 2, 2, 1, 3, 1, 0, 0, 2, 1, 2, 0, 0, 0, 2, 3, 3, 1, 1, 4, 5, 4, 0, 4, 4, 4, 1, 1, 3, 1, 0, 1, 3, 3, 1, 1, 1, 2, 0, 2, 1, 1, 1, 1, 1, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 0, 0, 0, 0, 0, 0, 0, 
		0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 2, 2, 2, 2, 2, 0, 0, 4, 3, 3, 1, 1, 1, 2, 2, 1, 1, 1, 2, 0, 0, 0, 0, 4, 3, 3, 1, 2, 2, 0, 0, 1, 1, 2, 0, 3, 6, 3, 0, 0, 0, 0, 0, 0, 3, 5, 5, 0, 2, 0, 0, 0, 0, 0, 0, 2, 1, 1, 1, 1, 3, 3, 3, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 0, 0, 0, 0, 0, 0, 0, 
		0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, 2, 2, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 4, 3, 0, 0, 2, 4, 1, 2, 0, 1, 4, 5, 5, 6, 7, 7, 7, 8, 9, 9, 7, 10, 11, 12, 13, 1, 0, 0, 2, 0, 2, 1, 2, 0, 2, 3, 4, 4, 0, 0, 0, 0, 0, 0, 0, 0, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 0, 0, 0, 0, 0, 0, 0, 
		0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, 2, 0, 0, 2, 3, 0, 0, 0, 2, 2, 2, 3, 4, 0, 0, 2, 14, 15, 7, 9, 9, 16, 10, 10, 10, 16, 7, 8, 17, 9, 7, 17, 12, 18, 6, 4, 1, 3, 1, 1, 0, 0, 3, 6, 6, 3, 1, 2, 0, 0, 0, 0, 0, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 0, 0, 0, 0, 0, 0, 0, 
		0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 4, 4, 6, 4, 3, 3, 3, 4, 5, 3, 2, 2, 3, 3, 2, 0, 19, 9, 7, 8, 7, 7, 8, 17, 7, 7, 7, 7, 7, 9, 7, 8, 10, 16, 16, 20, 20, 20, 20, 15, 18, 14, 6, 2, 0, 0, 0, 0, 4, 4, 3, 3, 3, 3, 4, 6, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 0, 0, 0, 0, 0, 0, 0, 
		0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, 2, 2, 2, 3, 1, 2, 2, 2, 2, 0, 0, 1, 2, 1, 18, 17, 9, 21, 9, 7, 16, 10, 8, 7, 9, 7, 7, 10, 16, 7, 8, 16, 8, 8, 20, 20, 8, 7, 7, 7, 7, 7, 8, 16, 16, 15, 12, 18, 5, 6, 3, 2, 0, 0, 0, 0, 2, 3, 4, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 0, 0, 0, 0, 0, 0, 0, 
		0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, 2, 2, 2, 2, 1, 2, 0, 0, 2, 6, 14, 14, 4, 19, 7, 7, 8, 7, 7, 7, 20, 10, 16, 10, 16, 10, 16, 16, 16, 8, 7, 9, 9, 7, 7, 7, 7, 7, 9, 9, 7, 8, 16, 16, 20, 19, 19, 21, 8, 20, 17, 15, 22, 18, 5, 6, 3, 2, 0, 0, 0, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 0, 0, 0, 0, 0, 0, 0, 
		0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, 2, 2, 2, 2, 1, 1, 1, 5, 3, 4, 23, 24, 16, 8, 10, 8, 8, 16, 8, 16, 8, 8, 8, 7, 25, 25, 21, 9, 9, 9, 21, 16, 7, 9, 7, 7, 7, 7, 7, 8, 7, 7, 16, 16, 7, 7, 7, 16, 7, 7, 8, 8, 7, 7, 16, 9, 8, 17, 11, 23, 5, 6, 4, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 0, 0, 0, 0, 0, 0, 0, 
		4, 3, 0, 0, 2, 6, 3, 2, 1, 4, 13, 13, 3, 0, 1, 23, 3, 13, 18, 6, 4, 5, 18, 6, 16, 24, 26, 7, 27, 16, 8, 7, 7, 9, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 21, 28, 7, 24, 25, 10, 20, 11, 17, 12, 13, 4, 6, 5, 5, 4, 14, 4, 3, 4, 3, 0, 3, 13, 23, 0, 18, 4, 23, 0, 11, 
		2, 3, 3, 3, 6, 1, 0, 0, 6, 2, 0, 0, 4, 4, 0, 0, 0, 0, 0, 0, 23, 20, 8, 17, 26, 8, 7, 10, 7, 29, 8, 8, 9, 9, 9, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 21, 17, 20, 15, 28, 17, 29, 16, 25, 20, 12, 5, 4, 3, 0, 0, 0, 0, 3, 14, 18, 14, 3, 0, 1, 0, 6, 0, 2, 4, 0, 
		4, 1, 0, 1, 4, 0, 0, 4, 0, 1, 2, 0, 1, 12, 16, 7, 19, 30, 31, 32, 33, 34, 34, 33, 35, 29, 21, 7, 25, 9, 20, 19, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 36, 37, 26, 27, 38, 39, 40, 41, 42, 34, 43, 44, 45, 46, 16, 46, 29, 20, 6, 0, 0, 6, 14, 3, 3, 0, 13, 3, 3, 15, 
		0, 0, 0, 0, 2, 0, 12, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 56, 57, 58, 55, 59, 60, 61, 45, 7, 10, 8, 7, 16, 21, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 25, 25, 26, 9, 62, 63, 55, 64, 58, 57, 65, 66, 67, 67, 68, 68, 57, 69, 70, 51, 71, 72, 73, 61, 74, 32, 75, 18, 3, 0, 0, 
		6, 76, 77, 78, 79, 78, 78, 80, 81, 82, 83, 84, 81, 78, 78, 85, 82, 82, 78, 81, 86, 81, 78, 78, 87, 75, 6, 23, 17, 29, 21, 24, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 10, 88, 32, 76, 78, 89, 81, 81, 81, 82, 90, 78, 78, 78, 78, 81, 78, 78, 81, 90, 78, 78, 79, 80, 78, 91, 83, 92, 78, 0, 
		93, 94, 95, 96, 97, 98, 96, 99, 94, 98, 98, 93, 96, 98, 100, 100, 101, 100, 95, 95, 98, 102, 98, 96, 103, 7, 0, 12, 15, 9, 21, 16, 8, 8, 8, 8, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 88, 21, 15, 104, 65, 78, 105, 106, 107, 97, 97, 108, 108, 108, 107, 94, 98, 98, 93, 95, 107, 102, 100, 98, 109, 107, 100, 58, 98, 93, 1, 
		5, 0, 0, 5, 4, 0, 0, 12, 0, 3, 5, 13, 6, 2, 0, 0, 0, 0, 6, 14, 4, 2, 0, 0, 23, 0, 4, 12, 15, 16, 8, 19, 8, 8, 8, 8, 8, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 110, 29, 7, 111, 112, 84, 3, 0, 6, 1, 2, 0, 0, 0, 0, 0, 0, 4, 13, 14, 0, 0, 0, 4, 0, 14, 1, 18, 0, 6, 0, 
		2, 14, 6, 0, 3, 13, 6, 0, 13, 3, 2, 1, 1, 2, 4, 18, 18, 5, 4, 6, 6, 6, 6, 5, 0, 18, 5, 0, 24, 37, 10, 7, 8, 8, 8, 8, 8, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 15, 16, 8, 41, 96, 78, 0, 12, 5, 5, 5, 14, 14, 14, 14, 14, 14, 2, 0, 4, 18, 13, 3, 2, 0, 1, 0, 5, 6, 0, 4, 
		0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 23, 2, 29, 32, 45, 33, 45, 113, 33, 113, 33, 113, 33, 113, 33, 113, 33, 113, 33, 113, 33, 113, 33, 113, 33, 113, 33, 113, 33, 113, 33, 113, 33, 113, 33, 113, 33, 113, 33, 33, 75, 33, 75, 33, 75, 33, 75, 33, 40, 114, 115, 116, 78, 0, 11, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 
		0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 12, 0, 117, 118, 119, 120, 121, 99, 64, 64, 64, 64, 64, 64, 64, 64, 64, 64, 64, 64, 64, 64, 64, 64, 64, 64, 64, 64, 64, 64, 64, 64, 64, 64, 64, 64, 64, 64, 64, 64, 55, 55, 55, 55, 55, 55, 55, 55, 122, 64, 66, 91, 78, 81, 24, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 
		0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 123, 78, 83, 101, 78, 78, 78, 90, 82, 90, 82, 90, 82, 90, 82, 90, 82, 90, 82, 90, 82, 90, 82, 90, 82, 90, 82, 90, 82, 90, 82, 90, 82, 90, 82, 90, 82, 90, 82, 78, 90, 78, 90, 78, 90, 78, 90, 82, 80, 78, 78, 77, 80, 4, 13, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 
		0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 89, 100, 119, 116, 57, 106, 99, 94, 107, 94, 107, 94, 107, 94, 107, 94, 107, 94, 107, 94, 107, 94, 107, 94, 107, 94, 107, 94, 107, 94, 107, 94, 107, 94, 107, 94, 107, 94, 107, 107, 97, 107, 97, 107, 97, 107, 97, 100, 100, 108, 119, 108, 93, 6, 5, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 
		0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, 0, 1, 3, 1, 3, 2, 13, 0, 2, 0, 2, 0, 2, 0, 2, 0, 2, 0, 2, 0, 2, 0, 2, 0, 2, 0, 2, 0, 2, 0, 2, 0, 2, 0, 2, 0, 2, 0, 2, 2, 1, 2, 1, 2, 1, 2, 1, 0, 36, 0, 0, 1, 4, 3, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 
		0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 3, 6, 0, 0, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 4, 0, 5, 1, 36, 0, 8, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 );

		$p = 0;
		for ($i=0;$i<$width;$i++)
		{
			for ($j=0;$j<$height;$j++)
			{
				imagesetpixel($im,$i,$j,$pal[$picture[$p]]);
				$p++;
			}
		}

		imagepng($im);
		imagedestroy($im);

		exit;
	}
	// bouton précédent
	elseif ($_GET['GetImage'] == 'prevena')
	{
		header ("Content-type: image/png");

		$width  = 22;
		$height = 103;

		$testGD = get_extension_funcs("gd");
		if (!$testGD)
		{
			echo "<table width=\"22\" height=\"103\" border=\"1\">";
			echo "<tr><td>GD is not installed</td></tr>";
			echo "</table>";
			exit();
		}

		if (in_array ("imagecreatetruecolor",$testGD))
			$im = imagecreatetruecolor($width,$height);
		else $im = imagecreate($width,$height);

		// Palette creation
		$pal[0] = imagecolorallocate ($im, 250, 250, 250);
		$pal[1] = imagecolorallocate ($im, 252, 252, 252);
		$pal[2] = imagecolorallocate ($im, 254, 254, 254);
		$pal[3] = imagecolorallocate ($im, 255, 255, 255);
		$pal[4] = imagecolorallocate ($im, 253, 253, 253);
		$pal[5] = imagecolorallocate ($im, 251, 251, 251);
		$pal[6] = imagecolorallocate ($im, 246, 246, 246);
		$pal[7] = imagecolorallocate ($im, 248, 248, 248);
		$pal[8] = imagecolorallocate ($im, 237, 237, 237);
		$pal[9] = imagecolorallocate ($im, 230, 230, 230);
		$pal[10] = imagecolorallocate ($im, 227, 227, 227);
		$pal[11] = imagecolorallocate ($im, 229, 229, 229);
		$pal[12] = imagecolorallocate ($im, 232, 232, 232);
		$pal[13] = imagecolorallocate ($im, 240, 240, 240);
		$pal[14] = imagecolorallocate ($im, 247, 247, 247);
		$pal[15] = imagecolorallocate ($im, 243, 243, 243);
		$pal[16] = imagecolorallocate ($im, 245, 245, 245);
		$pal[17] = imagecolorallocate ($im, 239, 239, 239);
		$pal[18] = imagecolorallocate ($im, 233, 233, 233);
		$pal[19] = imagecolorallocate ($im, 217, 217, 217);
		$pal[20] = imagecolorallocate ($im, 206, 206, 206);
		$pal[21] = imagecolorallocate ($im, 200, 200, 200);
		$pal[22] = imagecolorallocate ($im, 196, 196, 196);
		$pal[23] = imagecolorallocate ($im, 199, 199, 199);
		$pal[24] = imagecolorallocate ($im, 202, 202, 202);
		$pal[25] = imagecolorallocate ($im, 211, 211, 211);
		$pal[26] = imagecolorallocate ($im, 220, 220, 220);
		$pal[27] = imagecolorallocate ($im, 244, 244, 244);
		$pal[28] = imagecolorallocate ($im, 238, 238, 238);
		$pal[29] = imagecolorallocate ($im, 231, 231, 231);
		$pal[30] = imagecolorallocate ($im, 212, 212, 212);
		$pal[31] = imagecolorallocate ($im, 204, 204, 204);
		$pal[32] = imagecolorallocate ($im, 191, 191, 191);
		$pal[33] = imagecolorallocate ($im, 183, 183, 183);
		$pal[34] = imagecolorallocate ($im, 176, 176, 176);
		$pal[35] = imagecolorallocate ($im, 173, 173, 173);
		$pal[36] = imagecolorallocate ($im, 174, 174, 174);
		$pal[37] = imagecolorallocate ($im, 178, 178, 178);
		$pal[38] = imagecolorallocate ($im, 186, 186, 186);
		$pal[39] = imagecolorallocate ($im, 193, 193, 193);
		$pal[40] = imagecolorallocate ($im, 192, 192, 192);
		$pal[41] = imagecolorallocate ($im, 235, 235, 235);
		$pal[42] = imagecolorallocate ($im, 242, 242, 242);
		$pal[43] = imagecolorallocate ($im, 221, 221, 221);
		$pal[44] = imagecolorallocate ($im, 215, 215, 215);
		$pal[45] = imagecolorallocate ($im, 207, 207, 207);
		$pal[46] = imagecolorallocate ($im, 187, 187, 187);
		$pal[47] = imagecolorallocate ($im, 180, 180, 180);
		$pal[48] = imagecolorallocate ($im, 179, 179, 179);
		$pal[49] = imagecolorallocate ($im, 167, 167, 167);
		$pal[50] = imagecolorallocate ($im, 166, 166, 166);
		$pal[51] = imagecolorallocate ($im, 168, 168, 168);
		$pal[52] = imagecolorallocate ($im, 169, 169, 169);
		$pal[53] = imagecolorallocate ($im, 181, 181, 181);
		$pal[54] = imagecolorallocate ($im, 218, 218, 218);
		$pal[55] = imagecolorallocate ($im, 226, 226, 226);
		$pal[56] = imagecolorallocate ($im, 241, 241, 241);
		$pal[57] = imagecolorallocate ($im, 234, 234, 234);
		$pal[58] = imagecolorallocate ($im, 209, 209, 209);
		$pal[59] = imagecolorallocate ($im, 184, 184, 184);
		$pal[60] = imagecolorallocate ($im, 165, 165, 165);
		$pal[61] = imagecolorallocate ($im, 163, 163, 163);
		$pal[62] = imagecolorallocate ($im, 156, 156, 156);
		$pal[63] = imagecolorallocate ($im, 157, 157, 157);
		$pal[64] = imagecolorallocate ($im, 162, 162, 162);
		$pal[65] = imagecolorallocate ($im, 164, 164, 164);
		$pal[66] = imagecolorallocate ($im, 170, 170, 170);
		$pal[67] = imagecolorallocate ($im, 177, 177, 177);
		$pal[68] = imagecolorallocate ($im, 194, 194, 194);
		$pal[69] = imagecolorallocate ($im, 213, 213, 213);
		$pal[70] = imagecolorallocate ($im, 219, 219, 219);
		$pal[71] = imagecolorallocate ($im, 195, 195, 195);
		$pal[72] = imagecolorallocate ($im, 161, 161, 161);
		$pal[73] = imagecolorallocate ($im, 197, 197, 197);
		$pal[74] = imagecolorallocate ($im, 224, 224, 224);
		$pal[75] = imagecolorallocate ($im, 214, 214, 214);
		$pal[76] = imagecolorallocate ($im, 190, 190, 190);
		$pal[77] = imagecolorallocate ($im, 208, 208, 208);
		$pal[78] = imagecolorallocate ($im, 175, 175, 175);
		$pal[79] = imagecolorallocate ($im, 160, 160, 160);
		$pal[80] = imagecolorallocate ($im, 171, 171, 171);
		$pal[81] = imagecolorallocate ($im, 205, 205, 205);
		$pal[82] = imagecolorallocate ($im, 216, 216, 216);
		$pal[83] = imagecolorallocate ($im, 155, 155, 155);
		$pal[84] = imagecolorallocate ($im, 154, 154, 154);
		$pal[85] = imagecolorallocate ($im, 153, 153, 153);
		$pal[86] = imagecolorallocate ($im, 222, 222, 222);
		$pal[87] = imagecolorallocate ($im, 189, 189, 189);
		$pal[88] = imagecolorallocate ($im, 203, 203, 203);
		$pal[89] = imagecolorallocate ($im, 182, 182, 182);
		$pal[90] = imagecolorallocate ($im, 150, 150, 150);
		$pal[91] = imagecolorallocate ($im, 144, 144, 144);
		$pal[92] = imagecolorallocate ($im, 142, 142, 142);
		$pal[93] = imagecolorallocate ($im, 143, 143, 143);
		$pal[94] = imagecolorallocate ($im, 146, 146, 146);
		$pal[95] = imagecolorallocate ($im, 149, 149, 149);
		$pal[96] = imagecolorallocate ($im, 140, 140, 140);
		$pal[97] = imagecolorallocate ($im, 136, 136, 136);
		$pal[98] = imagecolorallocate ($im, 225, 225, 225);
		$pal[99] = imagecolorallocate ($im, 201, 201, 201);
		$pal[100] = imagecolorallocate ($im, 118, 118, 118);
		$pal[101] = imagecolorallocate ($im, 92, 92, 92);
		$pal[102] = imagecolorallocate ($im, 65, 65, 65);
		$pal[103] = imagecolorallocate ($im, 54, 54, 54);
		$pal[104] = imagecolorallocate ($im, 50, 50, 50);
		$pal[105] = imagecolorallocate ($im, 40, 40, 40);
		$pal[106] = imagecolorallocate ($im, 35, 35, 35);
		$pal[107] = imagecolorallocate ($im, 31, 31, 31);
		$pal[108] = imagecolorallocate ($im, 27, 27, 27);
		$pal[109] = imagecolorallocate ($im, 29, 29, 29);
		$pal[110] = imagecolorallocate ($im, 30, 30, 30);
		$pal[111] = imagecolorallocate ($im, 33, 33, 33);
		$pal[112] = imagecolorallocate ($im, 39, 39, 39);
		$pal[113] = imagecolorallocate ($im, 47, 47, 47);
		$pal[114] = imagecolorallocate ($im, 99, 99, 99);
		$pal[115] = imagecolorallocate ($im, 135, 135, 135);
		$pal[116] = imagecolorallocate ($im, 75, 75, 75);
		$pal[117] = imagecolorallocate ($im, 43, 43, 43);
		$pal[118] = imagecolorallocate ($im, 34, 34, 34);
		$pal[119] = imagecolorallocate ($im, 41, 41, 41);
		$pal[120] = imagecolorallocate ($im, 44, 44, 44);
		$pal[121] = imagecolorallocate ($im, 48, 48, 48);
		$pal[122] = imagecolorallocate ($im, 53, 53, 53);
		$pal[123] = imagecolorallocate ($im, 110, 110, 110);
		$pal[124] = imagecolorallocate ($im, 107, 107, 107);
		$pal[125] = imagecolorallocate ($im, 91, 91, 91);
		$pal[126] = imagecolorallocate ($im, 102, 102, 102);
		$pal[127] = imagecolorallocate ($im, 101, 101, 101);
		$pal[128] = imagecolorallocate ($im, 94, 94, 94);
		$pal[129] = imagecolorallocate ($im, 100, 100, 100);
		$pal[130] = imagecolorallocate ($im, 95, 95, 95);
		$pal[131] = imagecolorallocate ($im, 103, 103, 103);
		$pal[132] = imagecolorallocate ($im, 98, 98, 98);
		$pal[133] = imagecolorallocate ($im, 129, 129, 129);
		$pal[134] = imagecolorallocate ($im, 151, 151, 151);
		$pal[135] = imagecolorallocate ($im, 71, 71, 71);
		$pal[136] = imagecolorallocate ($im, 59, 59, 59);
		$pal[137] = imagecolorallocate ($im, 89, 89, 89);
		$pal[138] = imagecolorallocate ($im, 90, 90, 90);
		$pal[139] = imagecolorallocate ($im, 97, 97, 97);
		$pal[140] = imagecolorallocate ($im, 93, 93, 93);
		$pal[141] = imagecolorallocate ($im, 115, 115, 115);
		$pal[142] = imagecolorallocate ($im, 188, 188, 188);
		$pal[143] = imagecolorallocate ($im, 42, 42, 42);
		$pal[144] = imagecolorallocate ($im, 158, 158, 158);
		$pal[145] = imagecolorallocate ($im, 25, 25, 25);
		$pal[146] = imagecolorallocate ($im, 127, 127, 127);
		$pal[147] = imagecolorallocate ($im, 28, 28, 28);
		$pal[148] = imagecolorallocate ($im, 145, 145, 145);
		$pal[149] = imagecolorallocate ($im, 139, 139, 139);
		$pal[150] = imagecolorallocate ($im, 9, 9, 9);
		$pal[151] = imagecolorallocate ($im, 63, 63, 63);
		$pal[152] = imagecolorallocate ($im, 60, 60, 60);
		$pal[153] = imagecolorallocate ($im, 64, 64, 64);
		$pal[154] = imagecolorallocate ($im, 73, 73, 73);
		$pal[155] = imagecolorallocate ($im, 68, 68, 68);
		$pal[156] = imagecolorallocate ($im, 69, 69, 69);
		$pal[157] = imagecolorallocate ($im, 51, 51, 51);
		$pal[158] = imagecolorallocate ($im, 56, 56, 56);
		$pal[159] = imagecolorallocate ($im, 52, 52, 52);

		// Array of palette indice filling 
		$picture = array (
		0, 1, 2, 3, 2, 4, 4, 4, 1, 1, 4, 2, 2, 2, 4, 4, 4, 1, 1, 5, 5, 0, 0, 0, 3, 3, 3, 3, 3, 3, 2, 0, 6, 1, 3, 3, 3, 2, 2, 2, 2, 1, 4, 4, 0, 5, 5, 7, 8, 9, 10, 11, 9, 12, 13, 14, 15, 16, 6, 7, 5, 1, 1, 4, 15, 14, 4, 3, 4, 5, 0, 0, 6, 5, 2, 1, 1, 2, 2, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 2, 3, 3, 3, 3, 3, 2, 2, 2, 3, 3, 3, 3, 3, 
		5, 1, 2, 3, 2, 4, 4, 4, 1, 1, 4, 2, 2, 2, 4, 4, 1, 1, 1, 1, 1, 4, 4, 2, 5, 5, 5, 5, 1, 4, 2, 4, 4, 3, 2, 1, 0, 0, 5, 4, 4, 1, 2, 4, 14, 15, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 7, 4, 3, 3, 3, 1, 6, 27, 3, 3, 4, 5, 5, 4, 3, 3, 3, 3, 3, 5, 0, 1, 2, 4, 1, 1, 1, 1, 1, 1, 1, 1, 1, 4, 2, 2, 3, 2, 2, 4, 2, 2, 3, 3, 3, 3, 3, 
		1, 4, 2, 3, 2, 4, 1, 1, 1, 1, 4, 2, 2, 2, 4, 4, 4, 1, 1, 1, 1, 1, 4, 2, 1, 1, 1, 5, 5, 1, 2, 3, 3, 2, 4, 1, 5, 0, 14, 14, 28, 18, 29, 11, 19, 30, 31, 21, 32, 33, 34, 35, 36, 37, 38, 39, 33, 40, 20, 26, 11, 41, 42, 27, 5, 0, 5, 4, 3, 2, 0, 6, 0, 1, 4, 2, 2, 2, 5, 7, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 4, 4, 4, 4, 4, 4, 2, 2, 3, 3, 3, 3, 3, 
		1, 2, 3, 2, 4, 1, 1, 1, 1, 4, 4, 2, 2, 4, 4, 1, 2, 4, 1, 5, 0, 0, 0, 5, 4, 4, 4, 4, 5, 0, 5, 2, 5, 0, 0, 1, 5, 16, 28, 9, 43, 44, 45, 23, 46, 47, 48, 34, 49, 50, 50, 50, 51, 52, 35, 34, 37, 53, 32, 22, 24, 45, 54, 55, 4, 2, 1, 1, 5, 4, 1, 1, 0, 5, 5, 1, 4, 1, 7, 16, 2, 4, 4, 1, 1, 1, 1, 1, 1, 1, 1, 4, 4, 4, 4, 4, 2, 2, 3, 3, 3, 3, 3, 
		4, 2, 2, 2, 4, 1, 1, 1, 1, 4, 4, 2, 2, 4, 4, 1, 4, 4, 4, 1, 1, 1, 1, 1, 4, 1, 4, 2, 5, 6, 27, 16, 27, 56, 8, 57, 9, 26, 58, 31, 32, 59, 47, 36, 50, 60, 50, 61, 62, 63, 64, 65, 50, 65, 61, 61, 65, 50, 51, 66, 35, 67, 46, 68, 33, 22, 69, 10, 41, 42, 6, 1, 3, 2, 5, 5, 1, 2, 3, 3, 2, 2, 2, 2, 4, 4, 4, 4, 4, 4, 4, 4, 4, 2, 2, 2, 2, 2, 3, 3, 3, 3, 3, 
		4, 4, 2, 2, 4, 1, 1, 4, 4, 4, 2, 2, 2, 4, 1, 1, 1, 1, 2, 3, 3, 3, 2, 2, 2, 5, 0, 4, 0, 15, 17, 28, 9, 70, 58, 31, 71, 59, 37, 34, 65, 72, 65, 50, 61, 61, 64, 72, 65, 65, 64, 64, 64, 64, 64, 64, 50, 49, 52, 49, 50, 50, 49, 66, 47, 59, 32, 39, 73, 45, 74, 57, 7, 0, 2, 3, 2, 7, 16, 6, 3, 3, 3, 2, 2, 2, 4, 4, 4, 4, 4, 4, 4, 4, 2, 2, 2, 2, 3, 3, 3, 3, 3, 
		1, 4, 4, 4, 4, 1, 4, 2, 4, 4, 2, 2, 2, 4, 1, 1, 1, 4, 2, 3, 2, 1, 7, 6, 6, 56, 57, 57, 11, 26, 75, 58, 21, 76, 53, 37, 35, 50, 60, 50, 64, 64, 50, 51, 49, 51, 52, 50, 50, 50, 50, 65, 61, 65, 60, 65, 72, 64, 60, 65, 65, 61, 61, 65, 72, 65, 49, 66, 36, 37, 59, 32, 76, 23, 75, 11, 17, 15, 7, 2, 3, 3, 2, 2, 4, 4, 4, 1, 4, 1, 1, 5, 1, 1, 4, 2, 2, 2, 3, 3, 3, 3, 3, 
		1, 1, 4, 4, 4, 4, 2, 3, 4, 4, 2, 3, 2, 4, 1, 1, 4, 2, 3, 2, 5, 27, 56, 8, 18, 43, 69, 77, 24, 32, 37, 78, 51, 60, 65, 50, 49, 60, 50, 52, 50, 64, 64, 72, 79, 72, 60, 61, 79, 64, 65, 65, 60, 60, 65, 64, 60, 65, 61, 64, 64, 65, 60, 50, 65, 60, 60, 60, 50, 49, 80, 35, 47, 53, 38, 32, 73, 81, 26, 18, 2, 2, 4, 2, 4, 1, 1, 1, 1, 5, 5, 0, 0, 5, 1, 4, 2, 2, 3, 3, 3, 3, 3, 
		15, 3, 3, 6, 6, 3, 3, 16, 1, 5, 14, 27, 6, 4, 2, 5, 16, 56, 8, 41, 11, 82, 81, 31, 68, 53, 35, 66, 51, 50, 60, 72, 65, 61, 61, 61, 65, 61, 61, 61, 64, 61, 61, 65, 65, 65, 65, 65, 65, 65, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 65, 65, 65, 65, 61, 61, 65, 61, 64, 65, 34, 52, 67, 52, 37, 47, 76, 31, 43, 12, 41, 42, 14, 4, 1, 4, 1, 4, 2, 3, 4, 7, 14, 5, 2, 4, 4, 3, 3, 
		5, 27, 6, 4, 5, 56, 42, 3, 16, 4, 3, 3, 4, 16, 56, 17, 29, 43, 69, 45, 24, 76, 47, 67, 51, 66, 51, 72, 83, 84, 72, 49, 61, 61, 61, 61, 61, 61, 61, 61, 64, 61, 61, 65, 65, 65, 65, 65, 61, 65, 65, 60, 60, 60, 60, 65, 60, 60, 60, 60, 60, 60, 60, 60, 65, 65, 65, 65, 65, 65, 65, 65, 85, 72, 62, 85, 49, 34, 67, 35, 37, 46, 32, 40, 23, 30, 10, 41, 14, 1, 1, 5, 14, 5, 4, 3, 2, 3, 3, 3, 3, 1, 4, 
		7, 4, 2, 4, 3, 3, 4, 16, 14, 56, 57, 29, 86, 75, 81, 81, 71, 38, 67, 35, 52, 50, 65, 65, 72, 50, 61, 79, 51, 80, 65, 72, 65, 65, 65, 65, 65, 65, 65, 65, 61, 61, 65, 65, 65, 65, 65, 61, 61, 61, 65, 60, 60, 60, 65, 65, 60, 60, 60, 60, 60, 60, 60, 60, 65, 65, 65, 60, 60, 60, 60, 60, 72, 80, 65, 80, 50, 60, 64, 65, 51, 35, 78, 36, 78, 47, 87, 40, 32, 58, 9, 15, 6, 6, 0, 2, 2, 7, 14, 2, 3, 5, 14, 
		2, 14, 27, 7, 4, 0, 27, 42, 42, 86, 20, 88, 73, 89, 50, 62, 50, 72, 85, 90, 91, 92, 93, 94, 85, 65, 63, 85, 50, 52, 65, 64, 65, 65, 65, 65, 65, 65, 65, 65, 61, 65, 65, 65, 65, 65, 61, 61, 61, 61, 65, 65, 60, 65, 65, 65, 65, 65, 65, 65, 65, 65, 65, 65, 60, 60, 60, 65, 65, 65, 65, 65, 66, 64, 90, 50, 95, 96, 97, 92, 96, 93, 90, 62, 72, 60, 65, 65, 36, 89, 32, 39, 23, 69, 12, 7, 6, 1, 4, 7, 7, 4, 3, 
		13, 2, 3, 56, 9, 98, 99, 66, 100, 101, 102, 103, 104, 105, 106, 107, 108, 109, 107, 110, 110, 111, 112, 113, 114, 115, 79, 61, 61, 72, 61, 35, 65, 65, 65, 65, 65, 65, 65, 65, 65, 65, 65, 65, 65, 61, 61, 64, 61, 61, 65, 65, 60, 65, 65, 65, 65, 65, 65, 65, 65, 65, 65, 65, 60, 60, 65, 61, 61, 64, 72, 72, 79, 64, 50, 97, 116, 117, 109, 108, 106, 111, 109, 110, 107, 107, 107, 118, 119, 120, 121, 122, 116, 123, 94, 66, 37, 69, 42, 0, 2, 3, 3, 
		1, 37, 124, 125, 126, 127, 128, 128, 129, 130, 130, 129, 127, 127, 129, 131, 128, 114, 127, 132, 128, 125, 130, 114, 133, 134, 80, 67, 66, 50, 65, 65, 65, 65, 65, 65, 65, 65, 65, 65, 65, 65, 60, 60, 65, 61, 64, 64, 61, 61, 65, 60, 60, 60, 65, 65, 65, 65, 65, 65, 65, 65, 65, 65, 60, 65, 65, 61, 64, 72, 79, 79, 72, 64, 62, 135, 136, 125, 126, 114, 125, 137, 138, 125, 139, 132, 127, 131, 131, 126, 114, 140, 101, 140, 139, 130, 132, 130, 128, 141, 66, 18, 3, 
		5, 0, 5, 3, 3, 2, 1, 1, 2, 2, 2, 7, 16, 6, 0, 4, 6, 7, 5, 5, 1, 4, 2, 2, 13, 30, 142, 80, 79, 72, 61, 85, 65, 65, 65, 65, 65, 65, 65, 65, 60, 60, 60, 60, 65, 61, 64, 72, 61, 65, 65, 60, 60, 60, 60, 65, 65, 65, 65, 65, 65, 65, 65, 65, 61, 61, 61, 61, 61, 61, 61, 61, 80, 79, 96, 143, 85, 3, 3, 56, 4, 4, 3, 3, 3, 1, 7, 7, 2, 2, 4, 4, 3, 3, 3, 2, 0, 3, 3, 1, 7, 4, 3, 
		7, 1, 2, 4, 5, 1, 4, 2, 4, 2, 4, 1, 3, 3, 3, 0, 1, 5, 0, 0, 1, 4, 0, 6, 56, 77, 32, 48, 72, 72, 52, 64, 65, 65, 65, 65, 65, 65, 65, 65, 60, 60, 60, 60, 65, 61, 64, 72, 65, 65, 60, 60, 60, 60, 60, 60, 65, 65, 65, 65, 65, 65, 65, 65, 64, 64, 61, 65, 65, 60, 60, 60, 144, 72, 90, 145, 63, 4, 15, 3, 1, 7, 0, 1, 5, 7, 5, 4, 4, 4, 1, 0, 0, 1, 5, 0, 4, 14, 6, 2, 3, 2, 1, 
		3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 4, 4, 2, 2, 4, 5, 7, 14, 17, 11, 31, 67, 50, 65, 61, 65, 65, 65, 65, 65, 65, 65, 65, 65, 65, 65, 65, 65, 65, 65, 65, 65, 65, 65, 65, 65, 65, 65, 65, 65, 65, 65, 65, 65, 65, 65, 65, 65, 65, 65, 65, 61, 61, 61, 61, 61, 61, 61, 115, 119, 78, 42, 3, 4, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 
		3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 2, 2, 3, 3, 2, 4, 5, 0, 13, 11, 88, 34, 60, 64, 144, 63, 61, 65, 61, 65, 61, 65, 61, 65, 61, 65, 61, 65, 61, 65, 61, 65, 61, 65, 61, 65, 61, 65, 61, 65, 61, 65, 61, 65, 61, 65, 61, 65, 65, 60, 61, 65, 61, 65, 61, 65, 50, 80, 146, 147, 30, 7, 15, 15, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 
		3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 2, 3, 3, 3, 3, 2, 4, 1, 27, 10, 32, 64, 95, 95, 95, 90, 92, 93, 92, 93, 92, 93, 92, 93, 92, 93, 92, 93, 92, 93, 92, 93, 92, 93, 92, 93, 92, 93, 92, 93, 92, 93, 92, 93, 92, 93, 92, 93, 93, 91, 93, 91, 93, 91, 93, 91, 148, 149, 137, 150, 19, 7, 0, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 
		3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 2, 2, 3, 3, 3, 3, 2, 4, 7, 58, 94, 138, 151, 152, 153, 154, 155, 155, 155, 155, 155, 155, 155, 155, 155, 155, 155, 155, 155, 155, 155, 155, 155, 155, 155, 155, 155, 155, 155, 155, 155, 155, 155, 155, 155, 155, 155, 155, 155, 155, 155, 155, 155, 156, 156, 156, 152, 157, 158, 159, 86, 3, 3, 42, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 
		3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 4, 2, 2, 2, 2, 2, 2, 4, 2, 1, 6, 27, 7, 16, 17, 29, 15, 42, 15, 42, 15, 42, 15, 42, 15, 42, 15, 42, 15, 42, 15, 42, 15, 42, 15, 42, 15, 42, 15, 42, 15, 42, 15, 42, 15, 42, 15, 42, 42, 42, 42, 42, 42, 42, 42, 42, 27, 15, 3, 42, 4, 27, 14, 6, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 
		3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 4, 4, 4, 4, 4, 4, 4, 4, 3, 2, 6, 16, 1, 2, 1, 4, 2, 4, 2, 4, 2, 4, 2, 4, 2, 4, 2, 4, 2, 4, 2, 4, 2, 4, 2, 4, 2, 4, 2, 4, 2, 4, 2, 4, 2, 4, 2, 4, 1, 5, 5, 5, 5, 5, 0, 0, 1, 0, 27, 3, 16, 4, 0, 5, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3 );

		$p = 0;
		for ($i=0;$i<$width;$i++)
		{
			for ($j=0;$j<$height;$j++)
			{
				imagesetpixel($im,$i,$j,$pal[$picture[$p]]);
				$p++;
			}
		}

		imagepng($im);
		imagedestroy($im);

		exit;
	}
    // bouton suivant grisé
	elseif ($_GET['GetImage'] == 'nextdis')
	{
		header ("Content-type: image/png");

		$width  = 22;
		$height = 103;

		$testGD = get_extension_funcs("gd");
		if (!$testGD)
		{
			echo "<table width=\"22\" height=\"103\" border=\"1\">";
			echo "<tr><td>GD is not installed</td></tr>";
			echo "</table>";
			exit();
		}

		if (in_array ("imagecreatetruecolor",$testGD))
			$im = imagecreatetruecolor($width,$height);
		else $im = imagecreate($width,$height);

		// Palette creation
		$pal[0] = imagecolorallocate ($im, 255, 255, 255);
		$pal[1] = imagecolorallocate ($im, 250, 250, 250);
		$pal[2] = imagecolorallocate ($im, 254, 254, 254);
		$pal[3] = imagecolorallocate ($im, 253, 253, 253);
		$pal[4] = imagecolorallocate ($im, 245, 245, 245);
		$pal[5] = imagecolorallocate ($im, 197, 197, 197);
		$pal[6] = imagecolorallocate ($im, 65, 65, 65);
		$pal[7] = imagecolorallocate ($im, 0, 0, 0);
		$pal[8] = imagecolorallocate ($im, 12, 12, 12);
		$pal[9] = imagecolorallocate ($im, 1, 1, 1);
		$pal[10] = imagecolorallocate ($im, 7, 7, 7);
		$pal[11] = imagecolorallocate ($im, 2, 2, 2);
		$pal[12] = imagecolorallocate ($im, 13, 13, 13);
		$pal[13] = imagecolorallocate ($im, 4, 4, 4);
		$pal[14] = imagecolorallocate ($im, 251, 251, 251);
		$pal[15] = imagecolorallocate ($im, 246, 246, 246);
		$pal[16] = imagecolorallocate ($im, 247, 247, 247);
		$pal[17] = imagecolorallocate ($im, 252, 252, 252);
		$pal[18] = imagecolorallocate ($im, 244, 244, 244);
		$pal[19] = imagecolorallocate ($im, 195, 195, 195);
		$pal[20] = imagecolorallocate ($im, 94, 94, 94);
		$pal[21] = imagecolorallocate ($im, 50, 50, 50);
		$pal[22] = imagecolorallocate ($im, 62, 62, 62);
		$pal[23] = imagecolorallocate ($im, 58, 58, 58);
		$pal[24] = imagecolorallocate ($im, 55, 55, 55);
		$pal[25] = imagecolorallocate ($im, 54, 54, 54);
		$pal[26] = imagecolorallocate ($im, 56, 56, 56);
		$pal[27] = imagecolorallocate ($im, 52, 52, 52);
		$pal[28] = imagecolorallocate ($im, 34, 34, 34);
		$pal[29] = imagecolorallocate ($im, 21, 21, 21);
		$pal[30] = imagecolorallocate ($im, 248, 248, 248);
		$pal[31] = imagecolorallocate ($im, 243, 243, 243);
		$pal[32] = imagecolorallocate ($im, 242, 242, 242);
		$pal[33] = imagecolorallocate ($im, 217, 217, 217);
		$pal[34] = imagecolorallocate ($im, 182, 182, 182);
		$pal[35] = imagecolorallocate ($im, 196, 196, 196);
		$pal[36] = imagecolorallocate ($im, 194, 194, 194);
		$pal[37] = imagecolorallocate ($im, 180, 180, 180);
		$pal[38] = imagecolorallocate ($im, 189, 189, 189);
		$pal[39] = imagecolorallocate ($im, 179, 179, 179);
		$pal[40] = imagecolorallocate ($im, 183, 183, 183);
		$pal[41] = imagecolorallocate ($im, 165, 165, 165);
		$pal[42] = imagecolorallocate ($im, 224, 224, 224);
		$pal[43] = imagecolorallocate ($im, 203, 203, 203);
		$pal[44] = imagecolorallocate ($im, 222, 222, 222);
		$pal[45] = imagecolorallocate ($im, 221, 221, 221);
		$pal[46] = imagecolorallocate ($im, 218, 218, 218);
		$pal[47] = imagecolorallocate ($im, 225, 225, 225);
		$pal[48] = imagecolorallocate ($im, 213, 213, 213);
		$pal[49] = imagecolorallocate ($im, 186, 186, 186);
		$pal[50] = imagecolorallocate ($im, 15, 15, 15);
		$pal[51] = imagecolorallocate ($im, 237, 237, 237);
		$pal[52] = imagecolorallocate ($im, 226, 226, 226);
		$pal[53] = imagecolorallocate ($im, 216, 216, 216);
		$pal[54] = imagecolorallocate ($im, 229, 229, 229);
		$pal[55] = imagecolorallocate ($im, 209, 209, 209);
		$pal[56] = imagecolorallocate ($im, 220, 220, 220);
		$pal[57] = imagecolorallocate ($im, 227, 227, 227);
		$pal[58] = imagecolorallocate ($im, 36, 36, 36);
		$pal[59] = imagecolorallocate ($im, 241, 241, 241);
		$pal[60] = imagecolorallocate ($im, 232, 232, 232);
		$pal[61] = imagecolorallocate ($im, 238, 238, 238);
		$pal[62] = imagecolorallocate ($im, 219, 219, 219);
		$pal[63] = imagecolorallocate ($im, 215, 215, 215);
		$pal[64] = imagecolorallocate ($im, 208, 208, 208);
		$pal[65] = imagecolorallocate ($im, 239, 239, 239);
		$pal[66] = imagecolorallocate ($im, 33, 33, 33);
		$pal[67] = imagecolorallocate ($im, 10, 10, 10);
		$pal[68] = imagecolorallocate ($im, 125, 125, 125);
		$pal[69] = imagecolorallocate ($im, 5, 5, 5);
		$pal[70] = imagecolorallocate ($im, 3, 3, 3);
		$pal[71] = imagecolorallocate ($im, 81, 81, 81);
		$pal[72] = imagecolorallocate ($im, 231, 231, 231);
		$pal[73] = imagecolorallocate ($im, 228, 228, 228);
		$pal[74] = imagecolorallocate ($im, 184, 184, 184);
		$pal[75] = imagecolorallocate ($im, 105, 105, 105);
		$pal[76] = imagecolorallocate ($im, 204, 204, 204);
		$pal[77] = imagecolorallocate ($im, 117, 117, 117);
		$pal[78] = imagecolorallocate ($im, 84, 84, 84);
		$pal[79] = imagecolorallocate ($im, 69, 69, 69);
		$pal[80] = imagecolorallocate ($im, 64, 64, 64);
		$pal[81] = imagecolorallocate ($im, 46, 46, 46);
		$pal[82] = imagecolorallocate ($im, 41, 41, 41);
		$pal[83] = imagecolorallocate ($im, 42, 42, 42);
		$pal[84] = imagecolorallocate ($im, 44, 44, 44);
		$pal[85] = imagecolorallocate ($im, 132, 132, 132);
		$pal[86] = imagecolorallocate ($im, 214, 214, 214);
		$pal[87] = imagecolorallocate ($im, 170, 170, 170);
		$pal[88] = imagecolorallocate ($im, 98, 98, 98);
		$pal[89] = imagecolorallocate ($im, 53, 53, 53);
		$pal[90] = imagecolorallocate ($im, 48, 48, 48);
		$pal[91] = imagecolorallocate ($im, 40, 40, 40);
		$pal[92] = imagecolorallocate ($im, 67, 67, 67);
		$pal[93] = imagecolorallocate ($im, 71, 71, 71);
		$pal[94] = imagecolorallocate ($im, 74, 74, 74);
		$pal[95] = imagecolorallocate ($im, 139, 139, 139);
		$pal[96] = imagecolorallocate ($im, 178, 178, 178);
		$pal[97] = imagecolorallocate ($im, 187, 187, 187);
		$pal[98] = imagecolorallocate ($im, 35, 35, 35);
		$pal[99] = imagecolorallocate ($im, 211, 211, 211);
		$pal[100] = imagecolorallocate ($im, 205, 205, 205);
		$pal[101] = imagecolorallocate ($im, 200, 200, 200);
		$pal[102] = imagecolorallocate ($im, 191, 191, 191);
		$pal[103] = imagecolorallocate ($im, 201, 201, 201);
		$pal[104] = imagecolorallocate ($im, 230, 230, 230);
		$pal[105] = imagecolorallocate ($im, 190, 190, 190);
		$pal[106] = imagecolorallocate ($im, 188, 188, 188);
		$pal[107] = imagecolorallocate ($im, 192, 192, 192);
		$pal[108] = imagecolorallocate ($im, 193, 193, 193);
		$pal[109] = imagecolorallocate ($im, 212, 212, 212);
		$pal[110] = imagecolorallocate ($im, 234, 234, 234);
		$pal[111] = imagecolorallocate ($im, 233, 233, 233);
		$pal[112] = imagecolorallocate ($im, 235, 235, 235);
		$pal[113] = imagecolorallocate ($im, 240, 240, 240);

		// Array of palette indice filling 
		$picture = array (
		0, 1, 1, 0, 0, 2, 3, 0, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 0, 0, 0, 0, 4, 5, 6, 7, 8, 9, 7, 10, 7, 9, 7, 9, 7, 9, 7, 9, 7, 9, 7, 9, 7, 9, 7, 9, 9, 11, 9, 11, 9, 11, 9, 11, 9, 11, 9, 11, 9, 11, 9, 11, 7, 9, 7, 9, 7, 9, 7, 9, 9, 9, 12, 13, 7, 2, 0, 2, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 14, 15, 0, 0, 14, 0, 16, 
		14, 0, 0, 2, 14, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 17, 17, 17, 17, 17, 3, 3, 3, 0, 18, 19, 20, 21, 6, 22, 23, 24, 25, 24, 25, 24, 25, 24, 25, 24, 25, 24, 25, 24, 25, 24, 25, 26, 24, 26, 24, 26, 24, 26, 24, 26, 24, 26, 24, 26, 24, 26, 24, 24, 25, 24, 25, 24, 25, 24, 25, 6, 27, 28, 7, 29, 0, 0, 30, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 0, 0, 31, 32, 0, 15, 0, 
		3, 2, 3, 3, 0, 0, 2, 15, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 33, 34, 35, 36, 37, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 39, 40, 41, 9, 11, 0, 17, 17, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 30, 30, 0, 16, 0, 1, 1, 
		3, 17, 3, 2, 30, 4, 14, 0, 3, 3, 3, 3, 3, 3, 3, 3, 14, 14, 14, 14, 14, 14, 14, 14, 30, 0, 17, 14, 42, 43, 44, 45, 33, 33, 33, 33, 33, 33, 33, 33, 33, 33, 33, 33, 33, 33, 33, 33, 33, 46, 33, 46, 33, 46, 33, 46, 33, 46, 33, 46, 33, 46, 33, 46, 33, 33, 33, 33, 33, 33, 33, 33, 47, 48, 49, 50, 13, 32, 51, 0, 14, 14, 14, 14, 14, 14, 14, 14, 14, 14, 14, 14, 14, 14, 14, 14, 0, 16, 2, 0, 3, 0, 0, 
		0, 0, 0, 2, 0, 0, 3, 30, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 30, 4, 52, 53, 54, 55, 56, 56, 56, 56, 56, 56, 56, 56, 56, 56, 56, 56, 56, 56, 56, 56, 56, 56, 56, 56, 56, 56, 56, 56, 56, 56, 56, 56, 56, 56, 56, 56, 56, 56, 56, 56, 56, 56, 56, 56, 53, 57, 37, 58, 10, 17, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 59, 0, 60, 0, 32, 61, 0, 
		1, 0, 0, 1, 1, 0, 2, 18, 17, 14, 14, 14, 14, 14, 14, 14, 2, 2, 2, 2, 3, 3, 3, 3, 2, 60, 0, 3, 45, 44, 42, 52, 62, 46, 62, 46, 62, 46, 62, 46, 62, 46, 62, 46, 62, 46, 62, 46, 46, 33, 46, 33, 46, 33, 46, 33, 46, 33, 46, 33, 46, 33, 46, 33, 62, 46, 62, 46, 62, 46, 62, 46, 63, 64, 36, 58, 7, 0, 16, 30, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 3, 0, 3, 14, 0, 0, 32, 
		1, 15, 1, 0, 0, 14, 17, 0, 0, 0, 0, 0, 0, 0, 0, 0, 3, 2, 3, 2, 3, 3, 17, 3, 14, 65, 2, 32, 44, 46, 64, 53, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 47, 47, 47, 47, 47, 47, 47, 47, 47, 47, 47, 47, 47, 47, 47, 47, 52, 52, 52, 52, 52, 52, 52, 52, 47, 63, 5, 66, 67, 15, 2, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 65, 0, 65, 0, 18, 0, 
		14, 68, 12, 7, 8, 69, 7, 9, 9, 11, 9, 11, 9, 11, 9, 11, 11, 70, 11, 11, 9, 11, 9, 11, 71, 43, 4, 72, 42, 56, 73, 44, 62, 62, 62, 56, 62, 56, 62, 56, 62, 56, 62, 56, 62, 56, 62, 56, 33, 46, 33, 46, 33, 46, 33, 46, 33, 46, 33, 46, 33, 46, 33, 46, 62, 56, 62, 56, 62, 56, 62, 56, 53, 54, 74, 75, 12, 7, 8, 7, 7, 9, 7, 9, 7, 9, 7, 9, 7, 9, 7, 9, 7, 9, 7, 7, 7, 12, 9, 7, 67, 7, 14, 
		2, 3, 2, 0, 0, 2, 16, 31, 76, 41, 77, 78, 79, 6, 80, 25, 81, 82, 82, 83, 83, 84, 26, 79, 85, 49, 73, 73, 53, 62, 47, 46, 42, 42, 44, 45, 45, 44, 44, 56, 56, 56, 56, 56, 45, 42, 45, 62, 56, 56, 56, 56, 56, 56, 56, 56, 56, 62, 56, 45, 44, 44, 45, 45, 46, 46, 62, 56, 45, 44, 45, 45, 45, 62, 86, 87, 88, 89, 21, 90, 81, 91, 84, 90, 81, 83, 84, 81, 90, 24, 92, 93, 94, 20, 95, 96, 49, 97, 86, 2, 44, 98, 0, 
		0, 2, 3, 0, 0, 0, 17, 1, 0, 1, 17, 0, 0, 0, 18, 54, 33, 99, 100, 101, 102, 34, 74, 102, 103, 55, 33, 62, 56, 52, 42, 62, 44, 44, 45, 56, 56, 56, 46, 33, 56, 56, 56, 62, 45, 42, 47, 44, 56, 56, 56, 56, 56, 56, 56, 56, 45, 45, 56, 62, 62, 62, 62, 62, 45, 45, 44, 44, 45, 56, 46, 33, 56, 47, 104, 44, 103, 105, 105, 49, 49, 106, 107, 108, 5, 109, 47, 52, 109, 73, 14, 0, 0, 4, 30, 0, 0, 65, 14, 0, 4, 0, 17, 
		0, 2, 3, 3, 0, 0, 0, 0, 2, 1, 1, 14, 14, 3, 2, 17, 0, 14, 15, 32, 110, 52, 44, 42, 44, 53, 53, 47, 52, 46, 33, 73, 33, 33, 46, 56, 44, 42, 42, 44, 45, 45, 45, 56, 56, 45, 44, 47, 56, 56, 56, 56, 56, 56, 56, 56, 44, 45, 56, 62, 46, 62, 56, 56, 46, 62, 56, 44, 44, 42, 42, 44, 45, 44, 62, 48, 63, 56, 45, 46, 46, 54, 110, 111, 65, 14, 0, 14, 3, 3, 17, 17, 16, 31, 16, 3, 112, 0, 32, 0, 15, 0, 30, 
		0, 0, 3, 3, 0, 0, 0, 0, 3, 2, 0, 0, 0, 14, 16, 31, 2, 17, 14, 3, 3, 1, 16, 15, 15, 42, 109, 62, 47, 46, 46, 52, 42, 44, 45, 44, 44, 45, 62, 56, 44, 44, 44, 44, 56, 62, 62, 45, 56, 56, 56, 56, 56, 56, 56, 56, 56, 45, 45, 45, 45, 45, 44, 42, 45, 56, 45, 56, 56, 45, 45, 42, 33, 57, 47, 33, 47, 51, 32, 15, 16, 3, 0, 0, 2, 0, 0, 15, 16, 4, 16, 2, 0, 2, 3, 17, 0, 18, 14, 14, 0, 32, 0, 
		0, 2, 2, 2, 0, 0, 2, 3, 2, 14, 14, 17, 14, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, 17, 2, 0, 0, 113, 62, 63, 33, 44, 56, 46, 46, 45, 45, 44, 47, 56, 56, 45, 42, 44, 62, 46, 56, 45, 45, 45, 45, 45, 45, 45, 45, 62, 45, 44, 42, 45, 56, 56, 56, 57, 52, 42, 62, 33, 33, 46, 56, 62, 65, 32, 113, 32, 18, 31, 15, 17, 4, 18, 1, 4, 18, 16, 17, 0, 17, 30, 16, 1, 17, 2, 0, 0, 113, 0, 1, 110, 0, 30, 
		2, 2, 0, 0, 0, 2, 17, 14, 0, 2, 2, 0, 3, 3, 3, 16, 17, 14, 1, 1, 14, 14, 14, 14, 2, 1, 18, 18, 17, 0, 0, 14, 110, 73, 52, 47, 42, 62, 56, 44, 56, 33, 46, 44, 42, 45, 56, 44, 45, 45, 45, 45, 45, 45, 45, 45, 56, 44, 42, 44, 62, 46, 33, 33, 33, 62, 56, 42, 47, 54, 60, 110, 32, 16, 3, 3, 3, 0, 2, 3, 3, 18, 16, 0, 2, 15, 14, 0, 2, 2, 2, 2, 3, 17, 14, 14, 1, 0, 4, 0, 17, 0, 3, 
		2, 0, 0, 0, 0, 2, 2, 3, 0, 3, 2, 0, 2, 0, 2, 1, 17, 3, 2, 2, 0, 0, 0, 0, 14, 0, 0, 2, 3, 3, 17, 30, 0, 2, 15, 32, 112, 52, 62, 46, 54, 56, 46, 45, 42, 45, 56, 44, 45, 45, 45, 45, 45, 45, 45, 45, 45, 44, 44, 45, 62, 56, 42, 52, 62, 47, 72, 51, 59, 18, 1, 3, 0, 30, 17, 3, 15, 15, 14, 14, 17, 1, 0, 0, 0, 14, 30, 16, 1, 3, 0, 0, 0, 0, 0, 2, 0, 4, 2, 17, 0, 30, 31, 
		0, 0, 0, 0, 2, 0, 0, 0, 0, 3, 2, 0, 2, 0, 0, 0, 3, 0, 0, 0, 3, 3, 3, 17, 2, 3, 17, 14, 14, 17, 2, 0, 17, 30, 14, 0, 0, 17, 1, 14, 61, 57, 62, 56, 45, 62, 46, 56, 45, 45, 45, 45, 45, 45, 45, 45, 45, 44, 44, 45, 44, 52, 72, 61, 113, 18, 3, 0, 2, 14, 30, 30, 59, 110, 1, 0, 30, 18, 2, 3, 2, 2, 2, 14, 16, 3, 0, 0, 2, 0, 0, 3, 17, 3, 2, 2, 16, 0, 0, 0, 31, 15, 0, 
		0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, 30, 59, 54, 45, 33, 33, 46, 44, 44, 56, 56, 44, 47, 46, 45, 104, 59, 18, 32, 30, 0, 0, 14, 16, 3, 0, 17, 30, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 
		0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 16, 14, 2, 0, 0, 3, 17, 30, 57, 52, 42, 62, 62, 42, 104, 110, 31, 32, 30, 3, 3, 1, 17, 0, 0, 17, 30, 17, 0, 3, 1, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 
		0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 3, 0, 0, 0, 0, 0, 0, 14, 30, 4, 32, 32, 31, 17, 0, 0, 2, 2, 0, 0, 14, 1, 17, 0, 3, 1, 3, 0, 2, 14, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 
		0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, 17, 30, 16, 16, 0, 0, 0, 2, 17, 14, 14, 3, 14, 16, 15, 1, 17, 14, 14, 14, 0, 2, 17, 3, 0, 2, 17, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 
		0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, 2, 0, 0, 2, 2, 0, 0, 17, 3, 2, 2, 17, 30, 15, 18, 3, 14, 1, 14, 2, 0, 0, 0, 2, 0, 3, 3, 0, 0, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 
		0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, 2, 2, 2, 0, 0, 0, 0, 2, 3, 2, 2, 3, 14, 2, 0, 2, 3, 0, 0, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 );

		$p = 0;
		for ($i=0;$i<$width;$i++)
		{
			for ($j=0;$j<$height;$j++)
			{
				imagesetpixel($im,$i,$j,$pal[$picture[$p]]);
				$p++;
			}
		}

		imagepng($im);
		imagedestroy($im);
		exit;
	}
    // bouton suivant
	elseif ($_GET['GetImage'] == 'nextena')
	{
		header ("Content-type: image/png");

		$width  = 22;
		$height = 103;

		$testGD = get_extension_funcs("gd");
		if (!$testGD)
		{
			echo "<table width=\"22\" height=\"103\" border=\"1\">";
			echo "<tr><td>GD is not installed</td></tr>";
			echo "</table>";
			exit();
		}

		if (in_array ("imagecreatetruecolor",$testGD))
			$im = imagecreatetruecolor($width,$height);
		else $im = imagecreate($width,$height);

		// Palette creation
		$pal[0] = imagecolorallocate ($im, 251, 251, 251);
		$pal[1] = imagecolorallocate ($im, 254, 254, 254);
		$pal[2] = imagecolorallocate ($im, 253, 253, 253);
		$pal[3] = imagecolorallocate ($im, 252, 252, 252);
		$pal[4] = imagecolorallocate ($im, 248, 248, 248);
		$pal[5] = imagecolorallocate ($im, 240, 240, 240);
		$pal[6] = imagecolorallocate ($im, 229, 229, 229);
		$pal[7] = imagecolorallocate ($im, 238, 238, 238);
		$pal[8] = imagecolorallocate ($im, 241, 241, 241);
		$pal[9] = imagecolorallocate ($im, 235, 235, 235);
		$pal[10] = imagecolorallocate ($im, 243, 243, 243);
		$pal[11] = imagecolorallocate ($im, 239, 239, 239);
		$pal[12] = imagecolorallocate ($im, 242, 242, 242);
		$pal[13] = imagecolorallocate ($im, 255, 255, 255);
		$pal[14] = imagecolorallocate ($im, 233, 233, 233);
		$pal[15] = imagecolorallocate ($im, 245, 245, 245);
		$pal[16] = imagecolorallocate ($im, 250, 250, 250);
		$pal[17] = imagecolorallocate ($im, 247, 247, 247);
		$pal[18] = imagecolorallocate ($im, 230, 230, 230);
		$pal[19] = imagecolorallocate ($im, 164, 164, 164);
		$pal[20] = imagecolorallocate ($im, 99, 99, 99);
		$pal[21] = imagecolorallocate ($im, 77, 77, 77);
		$pal[22] = imagecolorallocate ($im, 76, 76, 76);
		$pal[23] = imagecolorallocate ($im, 84, 84, 84);
		$pal[24] = imagecolorallocate ($im, 82, 82, 82);
		$pal[25] = imagecolorallocate ($im, 85, 85, 85);
		$pal[26] = imagecolorallocate ($im, 80, 80, 80);
		$pal[27] = imagecolorallocate ($im, 81, 81, 81);
		$pal[28] = imagecolorallocate ($im, 86, 86, 86);
		$pal[29] = imagecolorallocate ($im, 73, 73, 73);
		$pal[30] = imagecolorallocate ($im, 72, 72, 72);
		$pal[31] = imagecolorallocate ($im, 46, 46, 46);
		$pal[32] = imagecolorallocate ($im, 128, 128, 128);
		$pal[33] = imagecolorallocate ($im, 244, 244, 244);
		$pal[34] = imagecolorallocate ($im, 209, 209, 209);
		$pal[35] = imagecolorallocate ($im, 151, 151, 151);
		$pal[36] = imagecolorallocate ($im, 152, 152, 152);
		$pal[37] = imagecolorallocate ($im, 148, 148, 148);
		$pal[38] = imagecolorallocate ($im, 140, 140, 140);
		$pal[39] = imagecolorallocate ($im, 142, 142, 142);
		$pal[40] = imagecolorallocate ($im, 141, 141, 141);
		$pal[41] = imagecolorallocate ($im, 145, 145, 145);
		$pal[42] = imagecolorallocate ($im, 144, 144, 144);
		$pal[43] = imagecolorallocate ($im, 143, 143, 143);
		$pal[44] = imagecolorallocate ($im, 125, 125, 125);
		$pal[45] = imagecolorallocate ($im, 4, 4, 4);
		$pal[46] = imagecolorallocate ($im, 92, 92, 92);
		$pal[47] = imagecolorallocate ($im, 212, 212, 212);
		$pal[48] = imagecolorallocate ($im, 175, 175, 175);
		$pal[49] = imagecolorallocate ($im, 160, 160, 160);
		$pal[50] = imagecolorallocate ($im, 161, 161, 161);
		$pal[51] = imagecolorallocate ($im, 162, 162, 162);
		$pal[52] = imagecolorallocate ($im, 163, 163, 163);
		$pal[53] = imagecolorallocate ($im, 166, 166, 166);
		$pal[54] = imagecolorallocate ($im, 165, 165, 165);
		$pal[55] = imagecolorallocate ($im, 29, 29, 29);
		$pal[56] = imagecolorallocate ($im, 110, 110, 110);
		$pal[57] = imagecolorallocate ($im, 246, 246, 246);
		$pal[58] = imagecolorallocate ($im, 234, 234, 234);
		$pal[59] = imagecolorallocate ($im, 201, 201, 201);
		$pal[60] = imagecolorallocate ($im, 171, 171, 171);
		$pal[61] = imagecolorallocate ($im, 153, 153, 153);
		$pal[62] = imagecolorallocate ($im, 25, 25, 25);
		$pal[63] = imagecolorallocate ($im, 103, 103, 103);
		$pal[64] = imagecolorallocate ($im, 225, 225, 225);
		$pal[65] = imagecolorallocate ($im, 192, 192, 192);
		$pal[66] = imagecolorallocate ($im, 177, 177, 177);
		$pal[67] = imagecolorallocate ($im, 157, 157, 157);
		$pal[68] = imagecolorallocate ($im, 154, 154, 154);
		$pal[69] = imagecolorallocate ($im, 155, 155, 155);
		$pal[70] = imagecolorallocate ($im, 21, 21, 21);
		$pal[71] = imagecolorallocate ($im, 98, 98, 98);
		$pal[72] = imagecolorallocate ($im, 222, 222, 222);
		$pal[73] = imagecolorallocate ($im, 194, 194, 194);
		$pal[74] = imagecolorallocate ($im, 170, 170, 170);
		$pal[75] = imagecolorallocate ($im, 135, 135, 135);
		$pal[76] = imagecolorallocate ($im, 38, 38, 38);
		$pal[77] = imagecolorallocate ($im, 95, 95, 95);
		$pal[78] = imagecolorallocate ($im, 196, 196, 196);
		$pal[79] = imagecolorallocate ($im, 137, 137, 137);
		$pal[80] = imagecolorallocate ($im, 102, 102, 102);
		$pal[81] = imagecolorallocate ($im, 94, 94, 94);
		$pal[82] = imagecolorallocate ($im, 100, 100, 100);
		$pal[83] = imagecolorallocate ($im, 97, 97, 97);
		$pal[84] = imagecolorallocate ($im, 176, 176, 176);
		$pal[85] = imagecolorallocate ($im, 158, 158, 158);
		$pal[86] = imagecolorallocate ($im, 169, 169, 169);
		$pal[87] = imagecolorallocate ($im, 88, 88, 88);
		$pal[88] = imagecolorallocate ($im, 101, 101, 101);
		$pal[89] = imagecolorallocate ($im, 90, 90, 90);
		$pal[90] = imagecolorallocate ($im, 105, 105, 105);
		$pal[91] = imagecolorallocate ($im, 216, 216, 216);
		$pal[92] = imagecolorallocate ($im, 174, 174, 174);
		$pal[93] = imagecolorallocate ($im, 149, 149, 149);
		$pal[94] = imagecolorallocate ($im, 124, 124, 124);
		$pal[95] = imagecolorallocate ($im, 89, 89, 89);
		$pal[96] = imagecolorallocate ($im, 67, 67, 67);
		$pal[97] = imagecolorallocate ($im, 56, 56, 56);
		$pal[98] = imagecolorallocate ($im, 53, 53, 53);
		$pal[99] = imagecolorallocate ($im, 48, 48, 48);
		$pal[100] = imagecolorallocate ($im, 41, 41, 41);
		$pal[101] = imagecolorallocate ($im, 34, 34, 34);
		$pal[102] = imagecolorallocate ($im, 35, 35, 35);
		$pal[103] = imagecolorallocate ($im, 37, 37, 37);
		$pal[104] = imagecolorallocate ($im, 107, 107, 107);
		$pal[105] = imagecolorallocate ($im, 138, 138, 138);
		$pal[106] = imagecolorallocate ($im, 168, 168, 168);
		$pal[107] = imagecolorallocate ($im, 167, 167, 167);
		$pal[108] = imagecolorallocate ($im, 127, 127, 127);
		$pal[109] = imagecolorallocate ($im, 33, 33, 33);
		$pal[110] = imagecolorallocate ($im, 31, 31, 31);
		$pal[111] = imagecolorallocate ($im, 39, 39, 39);
		$pal[112] = imagecolorallocate ($im, 42, 42, 42);
		$pal[113] = imagecolorallocate ($im, 51, 51, 51);
		$pal[114] = imagecolorallocate ($im, 59, 59, 59);
		$pal[115] = imagecolorallocate ($im, 60, 60, 60);
		$pal[116] = imagecolorallocate ($im, 71, 71, 71);
		$pal[117] = imagecolorallocate ($im, 104, 104, 104);
		$pal[118] = imagecolorallocate ($im, 182, 182, 182);
		$pal[119] = imagecolorallocate ($im, 213, 213, 213);
		$pal[120] = imagecolorallocate ($im, 207, 207, 207);
		$pal[121] = imagecolorallocate ($im, 202, 202, 202);
		$pal[122] = imagecolorallocate ($im, 191, 191, 191);
		$pal[123] = imagecolorallocate ($im, 150, 150, 150);
		$pal[124] = imagecolorallocate ($im, 156, 156, 156);
		$pal[125] = imagecolorallocate ($im, 181, 181, 181);
		$pal[126] = imagecolorallocate ($im, 193, 193, 193);
		$pal[127] = imagecolorallocate ($im, 195, 195, 195);
		$pal[128] = imagecolorallocate ($im, 211, 211, 211);
		$pal[129] = imagecolorallocate ($im, 228, 228, 228);
		$pal[130] = imagecolorallocate ($im, 224, 224, 224);
		$pal[131] = imagecolorallocate ($im, 214, 214, 214);
		$pal[132] = imagecolorallocate ($im, 203, 203, 203);
		$pal[133] = imagecolorallocate ($im, 184, 184, 184);
		$pal[134] = imagecolorallocate ($im, 180, 180, 180);
		$pal[135] = imagecolorallocate ($im, 173, 173, 173);
		$pal[136] = imagecolorallocate ($im, 179, 179, 179);
		$pal[137] = imagecolorallocate ($im, 189, 189, 189);
		$pal[138] = imagecolorallocate ($im, 220, 220, 220);
		$pal[139] = imagecolorallocate ($im, 205, 205, 205);
		$pal[140] = imagecolorallocate ($im, 183, 183, 183);
		$pal[141] = imagecolorallocate ($im, 199, 199, 199);
		$pal[142] = imagecolorallocate ($im, 231, 231, 231);
		$pal[143] = imagecolorallocate ($im, 218, 218, 218);
		$pal[144] = imagecolorallocate ($im, 178, 178, 178);
		$pal[145] = imagecolorallocate ($im, 186, 186, 186);
		$pal[146] = imagecolorallocate ($im, 190, 190, 190);
		$pal[147] = imagecolorallocate ($im, 187, 187, 187);
		$pal[148] = imagecolorallocate ($im, 237, 237, 237);
		$pal[149] = imagecolorallocate ($im, 226, 226, 226);
		$pal[150] = imagecolorallocate ($im, 204, 204, 204);
		$pal[151] = imagecolorallocate ($im, 232, 232, 232);
		$pal[152] = imagecolorallocate ($im, 221, 221, 221);
		$pal[153] = imagecolorallocate ($im, 200, 200, 200);
		$pal[154] = imagecolorallocate ($im, 227, 227, 227);
		$pal[155] = imagecolorallocate ($im, 217, 217, 217);
		$pal[156] = imagecolorallocate ($im, 208, 208, 208);

		// Array of palette indice filling 
		$picture = array (
		0, 1, 1, 0, 0, 1, 1, 2, 2, 2, 2, 3, 3, 0, 0, 0, 0, 0, 4, 4, 2, 3, 4, 4, 0, 1, 5, 6, 7, 8, 9, 10, 11, 11, 11, 11, 11, 11, 11, 11, 5, 5, 5, 5, 5, 5, 5, 5, 8, 12, 8, 12, 8, 12, 8, 12, 8, 12, 8, 12, 8, 12, 8, 12, 11, 11, 5, 5, 5, 5, 8, 8, 7, 12, 6, 13, 14, 15, 13, 13, 0, 3, 3, 2, 1, 1, 13, 13, 1, 2, 2, 2, 3, 3, 3, 3, 2, 3, 13, 13, 13, 16, 17, 
		17, 1, 13, 13, 3, 0, 4, 17, 2, 2, 2, 2, 2, 2, 1, 1, 3, 3, 16, 16, 1, 2, 16, 4, 13, 18, 19, 20, 21, 22, 21, 23, 24, 23, 24, 23, 24, 23, 24, 23, 23, 25, 23, 25, 23, 25, 23, 25, 26, 27, 26, 27, 26, 27, 26, 27, 26, 27, 26, 27, 26, 27, 26, 27, 24, 23, 23, 25, 23, 25, 23, 28, 29, 26, 30, 31, 32, 13, 17, 12, 2, 2, 2, 2, 2, 2, 2, 1, 2, 2, 2, 2, 2, 2, 2, 3, 13, 1, 3, 4, 16, 2, 13, 
		2, 2, 0, 17, 4, 2, 13, 13, 3, 2, 2, 2, 1, 1, 13, 13, 3, 2, 0, 0, 1, 2, 16, 16, 15, 33, 34, 19, 35, 36, 37, 38, 39, 39, 39, 39, 39, 39, 39, 39, 40, 40, 40, 40, 40, 40, 40, 40, 41, 42, 41, 42, 41, 42, 41, 42, 41, 42, 41, 42, 41, 42, 41, 42, 39, 40, 40, 40, 40, 43, 39, 43, 41, 35, 44, 45, 46, 13, 4, 13, 1, 2, 2, 2, 3, 3, 3, 3, 3, 3, 3, 3, 3, 2, 2, 2, 0, 1, 2, 16, 2, 13, 13, 
		2, 16, 4, 16, 1, 2, 4, 33, 2, 2, 2, 1, 1, 1, 1, 1, 3, 2, 0, 0, 1, 2, 16, 16, 8, 8, 47, 48, 49, 50, 51, 52, 53, 53, 53, 53, 53, 53, 53, 53, 53, 54, 53, 54, 53, 54, 53, 54, 53, 54, 53, 54, 53, 54, 53, 54, 53, 54, 53, 54, 53, 54, 53, 54, 53, 54, 53, 54, 53, 53, 53, 53, 53, 52, 41, 55, 56, 57, 0, 15, 2, 2, 2, 2, 2, 3, 3, 3, 3, 3, 3, 3, 2, 2, 2, 2, 2, 1, 1, 13, 13, 13, 1, 
		2, 2, 3, 2, 1, 1, 13, 13, 13, 13, 1, 1, 2, 2, 3, 3, 3, 2, 3, 0, 1, 2, 16, 0, 2, 58, 59, 60, 52, 52, 53, 48, 54, 19, 19, 19, 19, 19, 19, 19, 52, 52, 52, 52, 52, 52, 52, 52, 19, 19, 19, 19, 19, 19, 19, 19, 19, 19, 19, 19, 19, 19, 19, 19, 52, 52, 52, 52, 52, 52, 52, 52, 49, 61, 39, 62, 63, 12, 57, 16, 3, 3, 2, 2, 1, 1, 13, 13, 2, 2, 2, 2, 1, 1, 1, 13, 2, 17, 57, 4, 4, 57, 0, 
		57, 16, 2, 1, 16, 17, 0, 13, 13, 13, 13, 1, 2, 2, 3, 2, 3, 1, 2, 2, 13, 2, 0, 2, 17, 64, 65, 66, 60, 53, 67, 68, 50, 50, 50, 50, 50, 50, 50, 50, 49, 49, 49, 49, 49, 49, 49, 49, 19, 19, 19, 19, 19, 19, 19, 19, 19, 19, 19, 19, 19, 19, 19, 19, 50, 50, 50, 50, 49, 49, 49, 49, 53, 53, 69, 70, 71, 13, 7, 16, 2, 2, 2, 1, 13, 13, 13, 13, 1, 13, 13, 13, 13, 13, 13, 13, 2, 0, 1, 13, 13, 1, 1, 
		13, 0, 57, 0, 13, 13, 1, 2, 3, 3, 0, 0, 16, 16, 4, 4, 4, 3, 0, 16, 3, 16, 17, 16, 8, 72, 73, 74, 50, 49, 52, 19, 54, 54, 54, 54, 54, 54, 54, 54, 19, 19, 19, 19, 19, 19, 19, 19, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 54, 54, 54, 54, 19, 19, 19, 19, 53, 51, 75, 76, 77, 1, 57, 2, 16, 16, 0, 0, 0, 0, 3, 3, 3, 3, 3, 3, 0, 0, 0, 0, 13, 13, 2, 10, 17, 13, 13, 
		17, 78, 79, 80, 77, 20, 71, 81, 20, 20, 20, 82, 71, 20, 20, 20, 20, 82, 82, 20, 82, 71, 83, 82, 38, 50, 84, 74, 52, 19, 54, 51, 54, 54, 54, 54, 54, 54, 54, 54, 19, 19, 19, 19, 19, 19, 19, 19, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 54, 54, 54, 19, 19, 19, 52, 52, 85, 86, 42, 87, 76, 46, 88, 89, 20, 20, 20, 71, 71, 20, 71, 71, 82, 88, 20, 20, 20, 71, 71, 71, 87, 71, 20, 90, 35, 91, 1, 
		2, 2, 4, 10, 5, 64, 78, 92, 93, 94, 95, 96, 97, 98, 99, 100, 101, 101, 102, 103, 101, 101, 100, 98, 104, 105, 19, 106, 52, 50, 51, 51, 52, 51, 50, 85, 49, 51, 50, 85, 52, 52, 19, 19, 19, 19, 52, 51, 19, 19, 19, 19, 19, 19, 19, 19, 52, 52, 19, 19, 54, 19, 52, 52, 52, 52, 52, 50, 51, 52, 51, 50, 52, 107, 50, 108, 27, 31, 109, 102, 103, 103, 101, 55, 110, 76, 103, 110, 111, 112, 113, 114, 115, 116, 117, 38, 51, 118, 119, 7, 16, 2, 2, 
		4, 0, 0, 0, 1, 13, 17, 7, 11, 6, 91, 120, 121, 122, 84, 52, 49, 61, 123, 93, 42, 40, 42, 35, 93, 50, 86, 53, 52, 19, 107, 86, 54, 54, 19, 52, 19, 54, 53, 54, 52, 52, 19, 19, 54, 19, 19, 52, 19, 19, 19, 19, 19, 19, 19, 19, 52, 52, 19, 19, 19, 19, 52, 51, 53, 53, 53, 54, 53, 53, 54, 19, 124, 19, 53, 49, 93, 38, 42, 36, 105, 40, 41, 37, 61, 67, 19, 54, 52, 106, 125, 65, 126, 127, 128, 129, 17, 3, 13, 13, 1, 2, 1, 
		13, 13, 1, 4, 17, 0, 3, 16, 4, 57, 12, 12, 12, 58, 130, 131, 132, 126, 133, 134, 84, 106, 19, 52, 51, 52, 54, 54, 51, 50, 49, 49, 19, 54, 54, 19, 52, 52, 19, 54, 51, 52, 19, 19, 19, 19, 19, 19, 19, 19, 19, 19, 19, 19, 19, 19, 52, 19, 19, 19, 52, 52, 51, 51, 52, 52, 54, 54, 53, 53, 54, 54, 19, 54, 54, 54, 19, 19, 54, 54, 19, 107, 92, 84, 135, 92, 136, 137, 122, 121, 138, 9, 15, 4, 3, 1, 13, 13, 13, 1, 2, 2, 1, 
		3, 13, 13, 1, 1, 1, 1, 2, 3, 4, 17, 57, 4, 17, 57, 12, 138, 131, 139, 59, 126, 140, 84, 74, 48, 107, 54, 53, 107, 53, 51, 54, 54, 53, 54, 19, 51, 49, 50, 52, 51, 51, 52, 52, 52, 19, 19, 19, 19, 19, 19, 19, 19, 19, 19, 19, 19, 19, 19, 52, 52, 52, 51, 51, 50, 51, 19, 53, 53, 54, 19, 54, 51, 51, 51, 19, 53, 107, 106, 106, 48, 92, 66, 140, 137, 141, 91, 142, 5, 15, 3, 2, 13, 1, 4, 12, 15, 17, 16, 2, 13, 1, 3, 
		4, 0, 1, 13, 13, 13, 13, 1, 16, 0, 13, 13, 13, 13, 2, 16, 0, 4, 57, 12, 7, 129, 143, 91, 59, 137, 144, 48, 60, 53, 53, 60, 53, 53, 54, 54, 19, 50, 51, 19, 51, 51, 51, 51, 51, 52, 52, 52, 19, 19, 19, 19, 19, 19, 19, 19, 19, 19, 19, 52, 52, 52, 52, 52, 54, 19, 53, 53, 53, 52, 52, 54, 85, 54, 86, 92, 84, 136, 145, 146, 147, 127, 131, 58, 15, 33, 15, 16, 17, 3, 3, 16, 0, 13, 13, 2, 13, 13, 3, 2, 2, 13, 13, 
		13, 2, 0, 16, 16, 17, 33, 12, 3, 2, 1, 1, 1, 2, 3, 0, 17, 0, 1, 3, 17, 12, 148, 58, 149, 143, 34, 150, 127, 140, 144, 84, 60, 107, 53, 53, 54, 51, 50, 52, 52, 52, 51, 51, 51, 51, 52, 52, 19, 19, 19, 19, 19, 19, 19, 19, 19, 19, 52, 52, 52, 19, 19, 19, 19, 52, 19, 54, 19, 50, 51, 53, 134, 118, 140, 118, 118, 65, 128, 130, 12, 12, 15, 16, 2, 16, 0, 0, 16, 2, 2, 0, 16, 3, 1, 2, 0, 16, 4, 4, 0, 2, 13, 
		13, 2, 3, 2, 2, 2, 13, 1, 13, 13, 2, 0, 3, 2, 13, 13, 3, 1, 13, 13, 13, 1, 3, 4, 17, 57, 57, 10, 148, 64, 128, 132, 126, 133, 136, 144, 84, 86, 54, 54, 53, 53, 54, 19, 52, 52, 19, 19, 19, 19, 19, 19, 19, 19, 19, 19, 19, 19, 52, 52, 19, 54, 54, 53, 19, 19, 53, 74, 135, 135, 66, 140, 136, 78, 138, 5, 16, 16, 16, 4, 13, 13, 13, 2, 0, 3, 3, 16, 13, 13, 13, 13, 13, 1, 2, 1, 1, 13, 13, 13, 13, 2, 4, 
		16, 3, 1, 13, 13, 3, 3, 2, 0, 3, 1, 13, 13, 13, 1, 3, 2, 3, 3, 3, 1, 13, 13, 2, 2, 3, 0, 17, 17, 10, 7, 142, 130, 119, 132, 141, 73, 145, 66, 92, 107, 106, 53, 54, 54, 53, 54, 54, 19, 19, 19, 19, 19, 19, 19, 54, 19, 19, 52, 52, 19, 53, 53, 53, 74, 60, 84, 133, 122, 127, 132, 119, 18, 151, 11, 10, 17, 16, 0, 0, 4, 1, 13, 0, 16, 1, 13, 1, 1, 0, 0, 1, 13, 2, 3, 1, 1, 1, 13, 1, 2, 2, 13, 
		13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 17, 57, 33, 11, 18, 152, 128, 139, 127, 146, 134, 84, 74, 107, 51, 85, 67, 19, 19, 85, 49, 53, 106, 53, 54, 19, 53, 86, 74, 74, 84, 140, 126, 153, 128, 64, 7, 15, 2, 13, 13, 1, 1, 2, 1, 1, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 
		13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 2, 2, 1, 3, 17, 12, 148, 151, 64, 143, 119, 139, 59, 126, 133, 144, 54, 53, 53, 54, 54, 107, 106, 107, 92, 92, 136, 146, 126, 73, 153, 139, 5, 12, 15, 16, 2, 1, 1, 2, 1, 1, 1, 2, 1, 1, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 
		13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 0, 3, 1, 13, 13, 1, 3, 0, 33, 12, 9, 151, 154, 155, 34, 132, 140, 136, 66, 84, 48, 84, 144, 118, 140, 137, 150, 138, 14, 8, 4, 13, 16, 0, 3, 3, 3, 3, 0, 16, 1, 1, 1, 1, 1, 1, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 
		13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 16, 16, 0, 3, 3, 3, 3, 3, 4, 17, 57, 10, 12, 7, 142, 154, 47, 132, 65, 65, 65, 65, 59, 156, 148, 5, 33, 0, 1, 0, 0, 3, 17, 17, 16, 0, 2, 13, 13, 13, 1, 1, 1, 1, 1, 1, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 
		13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 1, 1, 2, 2, 3, 3, 3, 3, 3, 3, 3, 1, 2, 0, 16, 13, 10, 11, 5, 12, 5, 33, 13, 57, 17, 3, 2, 2, 3, 3, 3, 13, 1, 1, 2, 2, 2, 1, 1, 1, 1, 1, 1, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 
		13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 1, 1, 1, 2, 2, 3, 3, 3, 2, 2, 3, 2, 13, 13, 13, 13, 3, 57, 57, 3, 1, 16, 4, 3, 16, 16, 16, 16, 16, 16, 0, 0, 3, 0, 0, 16, 16, 0, 3, 3, 2, 1, 1, 13, 13, 13, 1, 1, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13 );

		$p = 0;
		for ($i=0;$i<$width;$i++)
		{
			for ($j=0;$j<$height;$j++)
			{
				imagesetpixel($im,$i,$j,$pal[$picture[$p]]);
				$p++;
			}
		}

		imagepng($im);
		imagedestroy($im);
		exit;
	}
	// une vignette
	else
	{
		$testGD = get_extension_funcs("gd");
		if (!$testGD)
		{
			echo "<table width=\"22\" height=\"103\" border=\"1\">";
			echo "<tr><td>GD is not installed</td></tr>";
			echo "</table>";
			exit();
		}

		header ("Content-type: image/png");
		
		$c = substr(urldecode($_GET['bgc']),1);
		

		$im = urldecode($_GET['GetImage']);
		$im_size = getimagesize($im);

		$im_size_x = $im_size[0];
		$im_size_y = $im_size[1];

		$thumb_max_x = $_GET['w'];
		$thumb_max_y = $_GET['h'];

		$thumb_width = $im_size_x;
		$thumb_height = $im_size_y; 

		if ($thumb_max_x > $thumb_max_y)
		{
			if ($im_size_x > $thumb_max_x)
			{
				$thumb_width = $thumb_max_x;
				$thumb_height = (int)(($thumb_max_x * $im_size_y) / $im_size_x); 
			}
		} elseif ($thumb_max_x < $thumb_max_y)
		{
		    if ($im_size_y > $thumb_max_y)
			{				
				$thumb_height = $thumb_max_y;  
				$thumb_width = (int)(($thumb_max_y * $im_size_x) / $im_size_y);
			} 
		} elseif ($thumb_max_x == $thumb_max_y)
		{
			if ($im_size_x > $thumb_max_x) 
			{
				$thumb_width = $thumb_max_x;
				$thumb_height = (int)(($thumb_max_x * $im_size_y) / $im_size_x); 
			} elseif ($im_size_y > $thumb_max_y)
			{
				$thumb_height = $thumb_max_y;  
				$thumb_width = (int)(($thumb_max_y * $im_size_x) / $im_size_y);
			}
		}

		if (in_array ("imagecreatetruecolor",$testGD))
			$thumb = imagecreatetruecolor($thumb_max_x,$thumb_max_y);
		else $thumb = imagecreate($thumb_max_x,$thumb_max_y);

		$bgcolor = imagecolorallocate(
				$thumb,
                (HexDec($c) & 0xFF0000) >> 16,
                (HexDec($c) & 0x00FF00) >>  8,
                (HexDec($c) & 0x0000FF)
                );

		$ext = strtolower(strrev(substr(strrev(urldecode($_GET['GetImage'])),0,strpos(strrev(urldecode($_GET['GetImage'])),"."))));

		if (($ext == "jpeg") || ($ext == "jpg"))
		{
			$im = ImageCreateFromJPEG($im);
		} elseif ($ext == "png") 
		{
			$im = ImageCreateFromPNG($im);
		} elseif ($ext == "gif")
		{
			$im = ImageCreateFromGIF($im);
		}
		
		imagefill($thumb,0,0,$bgcolor);

		imagecopyresampled($thumb, $im, (int)(($thumb_max_x - $thumb_width) / 2), (int)(($thumb_max_y - $thumb_height) / 2), 0, 0, $thumb_width, $thumb_height, $im_size_x, $im_size_y);

		
		imagepng($thumb);
		ImageDestroy($thumb);
		exit;
	}
}

class ImageBrowser
{
	// Variables publiques
	var $ImagePath;
	var $RecurseSubDir;
	var $ThumbPerPage;
	var $BackGroundcolor;
	var $ThumbWidth;
	var $ThumbHeight;
	var $ActivePage;
	var $ShowFilename;
	var $ShowIndex;

	var $PrevDis,$PrevEna,$NextDis,$NextEna;

	// Variables privées
	var $_ImgList = array();

	// Constructeur
	function ImageBrowser($path,$recurse = true)
	{
		$this->ImagePath = $path;
		$this->RecurseSubDir = $recurse;
		$this->ThumbPerPage = 4;
		$this->BackGroundColor = "#A2A2A2";
		$this->ThumbWidth = 150;
		$this->ThumbHeight = 100;
		$this->ActivePage = 1;
		$this->ShowFilename = false;
		$this->ShowIndex = true;

		if (isset($_GET['Page']))
		{
			$this->ActivePage = $_GET['Page'];
		}

		$this->PrevDis = "?GetImage=prevdis";
		$this->PrevEna = "?GetImage=prevena";
		$this->NextDis = "?GetImage=nextdis";
		$this->NextEna = "?GetImage=nextena";
	}

	// Gestion des erreurs
	function ImgBrowserError($error,$stop = false)
	{
		print($error);
		error_reporting(E_ALL);
		if ($stop) 
			exit;
	}

	// Private
	// recupération de la liste d'image
	function _FillImgList($path)
	{
		$ImagesDirectory = opendir($path);
		while($image = readdir($ImagesDirectory))
		{
			// Ajouter ici les extensions à prendre en compte
			if ((!is_dir($path."/".$image)) && 
				(stristr($image,".jpg") || 
				 stristr($image,".jpeg") || 
				 stristr($image,".gif") || 
				 stristr($image,".png")))
			{
				array_push($this->_ImgList,urlencode($path."/".$image));
			} 
			elseif (is_dir($path."/".$image) && ($image != ".") && ($image != "..") && $this->RecurseSubDir)
			{
				$this->_FillImgList(($path."/".$image));
			}	  
		}

		closedir($ImagesDirectory);
	}


	// Construction de la page
	// On considere que l'appel est fait entre <body> et </body>
	function ShowBrowser()
	{
		$i = 0;
		unset($this->_ImgList);
		$this->_ImgList = array();

		$BlankThumb = "?GetImage=blank&w=".$this->ThumbWidth."&h=".$this->ThumbHeight."&bgc=".urlencode($this->BackGroundColor);
		
		$this->_FillImgList($this->ImagePath);

		$i = count($this->_ImgList);

		$Thumbs_count = $i + 1;
		$nb_blanks = fmod($Thumbs_count - 1,$this->ThumbPerPage);

		for ($i=$Thumbs_count - 1;$i < $Thumbs_count + $nb_blanks;$i++)
		{
			array_push($this->_ImgList,$BlankThumb);
		}

		//print("<pre>");print_r( $this->_ImgList );print("</pre>");

		$Thumb_Without_Blank_count = $Thumbs_count;
		$Thumbs_count += $nb_blanks;

		if ($this->ActivePage > 1)
		{
			$FirstPhoto = (($this->ActivePage - 1) * $this->ThumbPerPage) + 1;
			$NextFirstPhoto = $FirstPhoto + $this->ThumbPerPage;
			if ($NextFirstPhoto >= $Thumbs_count - 1)
				$NextFirstPhoto = false;  
			$PrevPage = $this->ActivePage - 1;
		} else {
			$FirstPhoto = 0;
			if ($Thumbs_count - 1 > $this->ThumbPerPage) 
			{
				$NextFirstPhoto = $this->ThumbPerPage;  
			} else {
				$NextFirstPhoto = false;  
			}
			$PrevPage = false;
		}

		$MaxPage = floor($Thumbs_count / $this->ThumbPerPage);

		if ( $this->ActivePage < $MaxPage)
		  $NextPage = $this->ActivePage + 1;
		else $NextPage = false;

		$NextPreviousPhoto = $FirstPhoto - $this->ThumbPerPage;

		print("<div>");
		print("<form method=get action=\"\" name=\"frmPhotos\">\n");
		print("<div><input type=\"hidden\" name=\"Page\" value=\"".$this->ActivePage."\"></div>\n");
		print("<table width=\"100%\" height=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">\n");		
	    print("<tr height=\"100\">\n");
		print("<td>\n");
		
		print("<table width=\"100%\" height=\"100%\" cellpadding=\"0\" cellspacing=\"2\" border=\"0\">\n");
		print("<tr>\n");
		
		if ($PrevPage) {
			print("<td width=\"20\"><input type=\"image\" src=\"".$this->PrevEna."\" onclick=\"document.frmPhotos.Page.value='".$PrevPage."';\" width=\"20\" height=\"100\" border=\"0\"></td>\n");
		} else {
			print("<td width=\"20\"><img src=\"".$this->PrevDis."\" width=\"20\" height=\"100\" border=\"0\"></td>\n");
		}

		for($i=$FirstPhoto;$i<($FirstPhoto + $this->ThumbPerPage);$i++)
		{
			print("<td width=\"25%\"><table width=\"100%\" height=\"100%\" bgcolor=\"".$this->BackGroundColor."\"><tr><td align=\"center\">\n");
			if (! stristr($this->_ImgList[$i],$BlankThumb))
			{	
				print("<a href=\"javascript:document.getElementById('big').src='".addslashes(urldecode($this->_ImgList[$i]))."';void(0);\">\n");
			}	
			print("");
			if (! stristr($this->_ImgList[$i],$BlankThumb))
			{
				print("<img src=\"?GetImage=".$this->_ImgList[$i]."&w=".$this->ThumbWidth."&h=".$this->ThumbHeight."&bgc=".urlencode($this->BackGroundColor)."\"  border=\"0\" alt=\"\"></a></td></tr>\n");
			} else {
			    print("<img src=\"".$this->_ImgList[$i]."\"  border=\"0\" alt=\"\"></td></tr>\n");
			}
			if (($this->ShowFilename) && (! stristr($this->_ImgList[$i],$BlankThumb)))
			{
				print("<tr><td align=\"center\">".basename(urldecode($this->_ImgList[$i]))."</td></tr>\n");
			}
			if ($this->ShowIndex)
			{
				print("<tr><td align=\"center\">\n");
				if (! stristr($this->_ImgList[$i],$BlankThumb))
				{
					
					print(($i + 1)."/".($Thumb_Without_Blank_count - 1));
				}
				print("</td></tr>\n");
			}
			print("</table></td>\n");
		}
		
		if ($NextPage) {
			print("<td width=\"20\"><input type=\"image\" src=\"".$this->NextEna."\" onclick=\"document.frmPhotos.Page.value='".$NextPage."';\" width=\"20\" height=\"100\" border=\"0\"></td>\n");
		} else {
			print("<td width=\"20\"><img src=\"".$this->NextDis."\" width=\"20\" height=\"100\" border=\"0\"></td>\n");
		}

        print("</tr>\n");
		print("</table>\n");
		
		print("</td>\n");
	    print("</tr>\n");
	    print("<tr>\n");
		print("<td align=\"center\" width=\"100%\">\n");
		print("<img id=\"big\" src=\"".urldecode($this->_ImgList[$FirstPhoto])."\" border=\"0\" alt=\"\">\n");
		print("</td>\n");
	    print("</tr>\n");
	    print("</table>\n");
		print("</form>\n");
		print("</div>\n");
	}
}
//-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
?>