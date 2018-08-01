var pin_config = {
	'default':{
		'pinShadow':'#000', //shadow color below the points
		'pinShadowOpacity':'50', //shadow opacity, value, 0-100
	},
	'points':[
	{
		'shape':'rectangle',//choose the shape of the pin circle or rectangle
		'hover': '<u><b>Delhi</b></u><br>This pin when clicked will open<br>the URL in a <span style="color:black; background-color:#a9f038;"><b>NEW</b></span> window.',//the content of the hover popup
		'pos_X':183,//location of the pin on X axis
		'pos_Y':166,//location of the pin on Y axis
		'width':14,//width of the pin if rectangle (if circle use diameter)
		'height':14,//height of the pin if rectangle (if circle delete this line)
		'outline':'#FFF',//outline color of the pin
		'thickness':1,//thickness of the line (0 to hide the line)
		'upColor':'#0000FF',//color of the pin when map loads
		'overColor':'#3399ff',//color of the pin when mouse hover
		'downColor':'#00ffff',//color of the pin when clicked
		//(trick, if you make this pin un-clickable > make the overColor and downColor the same)
		'url':'http://localhost/wikilogy/mapdata.php?q=delhi?id=38',//URL of this pin
		'target':'new_window',//'new_window' opens URL in new window//'same_window' opens URL in the same window //'none' pin is not clickable
		'enable':true,//true/false to enable/disable this pin
	},
	{
		'shape':'circle',
		'hover': '<u><b>Mumbai</b></u><br><img src="example.png">Here you can write some <b>HTML</b><br>formated text.<br>This pin when clicked will open<br>the URL in the <span style="color:black; background-color:#a9f038;"><b>SAME</b></span> window.',
		'pos_X':96,
		'pos_Y':370,
		'diameter':14,
		'outline':'#FFF',
		'thickness':1,
		'upColor':'#FF0000',
		'overColor':'#FFEE148',
		'downColor':'#00ffff',
		'url':'http://localhost/wikilogy/mapdata.php?q=mumbai?id=39',
		'target':'same_window',
		'enable':true,
	},
	{
		'shape':'circle',
		'hover': 'Bangalore',
		'pos_X':189,
		'pos_Y':494,
		'diameter':14,
		'outline':'#FFF',
		'thickness':1,
		'upColor':'#FF0000',
		'overColor':'#FFEE88',
		'downColor':'#00ffff',
		'url':'http://localhost/wikilogy/mapdata.php?q=bangalore?id=40',
		'target':'same_window',
		'enable':true,
	},
	{
		'shape':'circle',
		'hover': 'Hyderabad',
		'pos_X':206,
		'pos_Y':397,
		'diameter':14,
		'outline':'#FFF',
		'thickness':1,
		'upColor':'#FF0000',
		'overColor':'#FFEE88',
		'downColor':'#00ffff',
		'url':'http://localhost/wikilogy/mapdata.php?q=hyderabad?id=41',
		'target':'same_window',
		'enable':true,
	},
	{
		'shape':'circle',
		'hover': 'Ahmedabad',
		'pos_X':93,
		'pos_Y':282,
		'diameter':14,
		'outline':'#FFF',
		'thickness':1,
		'upColor':'#FF0000',
		'overColor':'#FFEE88',
		'downColor':'#00ffff',
		'url':'http://localhost/wikilogy/mapdata.php?q=ahmedabad?id=42',
		'target':'same_window',
		'enable':true,
	},
	{
		'shape':'circle',
		'hover': 'Chennai',
		'pos_X':239,
		'pos_Y':488,
		'diameter':14,
		'outline':'#FFF',
		'thickness':1,
		'upColor':'#FF0000',
		'overColor':'#FFEE88',
		'downColor':'#00ffff',
		'url':'http://localhost/wikilogy/mapdata.php?q=chennai?id=43',
		'target':'same_window',
		'enable':true,
	},
	{
		'shape':'circle',
		'hover': 'Kolkata',
		'pos_X':397,
		'pos_Y':283,
		'diameter':14,
		'outline':'#FFF',
		'thickness':1,
		'upColor':'#FF0000',
		'overColor':'#FFEE88',
		'downColor':'#00ffff',
		'url':'http://localhost/wikilogy/mapdata.php?q=kolkata?id=44',
		'target':'same_window',
		'enable':true,
	},
	{
		'shape':'circle',
		'hover': 'Surat',
		'pos_X':100,
		'pos_Y':320,
		'diameter':14,
		'outline':'#FFF',
		'thickness':1,
		'upColor':'#FF0000',
		'overColor':'#FFEE88',
		'downColor':'#00ffff',
		'url':'http://localhost/wikilogy/mapdata.php?q=surat?id=45',
		'target':'same_window',
		'enable':true,
	},
	{
		'shape':'circle',
		'hover': 'Pune',
		'pos_X':117,
		'pos_Y':379,
		'diameter':14,
		'outline':'#FFF',
		'thickness':1,
		'upColor':'#FF0000',
		'overColor':'#FFEE88',
		'downColor':'#00ffff',
		'url':'http://localhost/wikilogy/mapdata.php?q=pune?id=46',
		'target':'same_window',
		'enable':true,
	},
	]
}
