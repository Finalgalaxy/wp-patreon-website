<?php
	
/* ---------------------------------------------------- */
/* All CSS Options and settings							*/
/* ---------------------------------------------------- */
echo "<ul class='yp-editor-list'>
		
		<li class='yp-li-about active'>
			<h3><small>".__('You are customizing','yp')."</small> <div>".yp_customizer_name()."</div></h3>
		</li>
		
		<li class='text-option'>
			<h3>".__('Text','yp')." ".yp_arrow_icon()."</h3>
			<div class='yp-this-content'>

				".yp_get_select_markup(
					'font-family',
					__('Font Family','yp')
					,array(
					
						// Safe Fonts.
						"Georgia, serif" => "Georgia",
						"'Helvetica Neue',Helvetica,Arial,sans-serif" => "Helvetica Neue",
						"'Times New Roman', Times, serif" => "Times New Roman",
						"Arial, Helvetica, sans-serif" => "Arial",
						"'Arial Black', Gadget, sans-serif" => "Arial Black",
						"Impact, Charcoal, sans-serif" => "Impact",
						"Tahoma, Geneva, sans-serif" => "Tahoma",
						"Verdana, Geneva, sans-serif" => "Verdana",
						
						// Google fonts.
						"'Open Sans', sans-serif" => "Open Sans",
						"'Roboto', sans-serif" => "Roboto",
						"'Slabo 27px', serif" => "Slabo 27px",
						"'Lato', sans-serif" => "Lato",
						"'Oswald', sans-serif" => "Oswald",
						"'Roboto Condensed', sans-serif" => "Roboto Condensed",
						"'Source Sans Pro', sans-serif" => "Source Sans Pro",
						"'Montserrat', sans-serif" => "Montserrat",
						"'Raleway', sans-serif" => "Raleway",
						"'PT Sans', sans-serif" => "PT Sans",
						"'Roboto Slab', serif" => "Roboto Slab",
						"'Open Sans Condensed', sans-serif" => "Open Sans Condensed",
						"'Droid Sans', sans-serif" => "Droid Sans",
						"'Lora', serif" => "Lora",
						"'Ubuntu', sans-serif" => "Ubuntu",
						"'Droid Serif', serif" => "Droid Serif",
						"'Merriweather', serif" => "Merriweather",
						"'Arimo', sans-serif" => "Arimo",
						"'Playfair Display', serif" => "Playfair Display",
						"'Noto Sans', sans-serif" => "Noto Sans",
						"'PT Sans Narrow', sans-serif" => "PT Sans Narrow",
						"'Titillium Web', sans-serif" => "Titillium Web",
						"'PT Serif', serif" => "PT Serif",
						"'Indie Flower', handwriting" => "Indie Flower",
						"'Muli', sans-serif" => "Muli",
						"'Inconsolata', monospace" => "Inconsolata",
						"'Bitter', serif" => "Bitter",
						"'Oxygen', sans-serif" => "Oxygen",
						"'Dosis', sans-serif" => "Dosis",
						"'Fjalla One', sans-serif" => "Fjalla One",
						"'Hind', sans-serif" => "Hind",
						"'Cabin', sans-serif" => "Cabin",
						"'Poppins', sans-serif" => "Poppins",
						"'Noto Serif', serif" => "Noto Serif",
						"'Lobster', display" => "Lobster",
						"'Arvo', serif" => "Arvo",
						"'Yanone Kaffeesatz', sans-serif" => "Yanone Kaffeesatz",
						"'Catamaran', sans-serif" => "Catamaran",
						"'Nunito', sans-serif" => "Nunito",
						"'Merriweather Sans', sans-serif" => "Merriweather Sans",
						"'Bree Serif', serif" => "Bree Serif",
						"'Libre Baskerville', serif" => "Libre Baskerville",
						"'Abel', sans-serif" => "Abel",
						"'Crimson Text', serif" => "Crimson Text",
						"'Josefin Sans', sans-serif" => "Josefin Sans",
						"'Anton', sans-serif" => "Anton",
						"'Asap', sans-serif" => "Asap",
						"'Exo 2', sans-serif" => "Exo 2",
						"'Varela Round', sans-serif" => "Varela Round",
						"'Ubuntu Condensed', sans-serif" => "Ubuntu Condensed",
						"'Fira Sans', sans-serif" => "Fira Sans",
						"'Pacifico', handwriting" => "Pacifico",
						"'Archivo Narrow', sans-serif" => "Archivo Narrow",
						"'Quicksand', sans-serif" => "Quicksand",
						"'Karla', sans-serif" => "Karla",
						"'Signika', sans-serif" => "Signika",
						"'Amatic SC', handwriting" => "Amatic SC",
						"'Cuprum', sans-serif" => "Cuprum",
						"'Francois One', sans-serif" => "Francois One",
						"'Play', sans-serif" => "Play",
						"'Questrial', sans-serif" => "Questrial",
						"'Shadows Into Light', handwriting" => "Shadows Into Light",
						"'Vollkorn', serif" => "Vollkorn",
						"'Roboto Mono', monospace" => "Roboto Mono",
						"'Alegreya', serif" => "Alegreya",
						"'Abril Fatface', display" => "Abril Fatface",
						"'PT Sans Caption', sans-serif" => "PT Sans Caption",
						"'Dancing Script', handwriting" => "Dancing Script",
						"'Exo', sans-serif" => "Exo",
						"'Maven Pro', sans-serif" => "Maven Pro",
						"'Poiret One', display" => "Poiret One",
						"'Rokkitt', serif" => "Rokkitt",
						"'Orbitron', sans-serif" => "Orbitron",
						"'Work Sans', sans-serif" => "Work Sans",
						"'Patua One', display" => "Patua One",
						"'Pathway Gothic One', sans-serif" => "Pathway Gothic One",
						"'Crete Round', serif" => "Crete Round",
						"'Gloria Hallelujah', handwriting" => "Gloria Hallelujah",
						"'Architects Daughter', handwriting" => "Architects Daughter",
						"'EB Garamond', serif" => "EB Garamond",
						"'Source Code Pro', monospace" => "Source Code Pro",
						"'Monda', sans-serif" => "Monda",
						"'Yellowtail', handwriting" => "Yellowtail",
						"'BenchNine', sans-serif" => "BenchNine",
						"'Ropa Sans', sans-serif" => "Ropa Sans",
						"'Quattrocento Sans', sans-serif" => "Quattrocento Sans",
						"'Rubik', sans-serif" => "Rubik",
						"'Acme', sans-serif" => "Acme",
						"'Domine', serif" => "Domine",
						"'Comfortaa', display" => "Comfortaa",
						"'Kaushan Script', handwriting" => "Kaushan Script",
						"'Hammersmith One', sans-serif" => "Hammersmith One",
						"'Righteous', display" => "Righteous",
						"'Josefin Slab', serif" => "Josefin Slab",
						"'Istok Web', sans-serif" => "Istok Web",
						"'Russo One', sans-serif" => "Russo One",
						"'Lobster Two', display" => "Lobster Two",
						"'Cinzel', serif" => "Cinzel",
						"'News Cycle', sans-serif" => "News Cycle",
						"'Alegreya Sans', sans-serif" => "Alegreya Sans",
						"'Noticia Text', serif" => "Noticia Text",
						"'Sanchez', serif" => "Sanchez",
						"'Satisfy', handwriting" => "Satisfy",
						"'Pontano Sans', sans-serif" => "Pontano Sans",
						"'Chewy', display" => "Chewy",
						"'Old Standard TT', serif" => "Old Standard TT",
						"'Coming Soon', handwriting" => "Coming Soon",
						"'Source Serif Pro', serif" => "Source Serif Pro",
						"'Gudea', sans-serif" => "Gudea",
						"'ABeeZee', sans-serif" => "ABeeZee",
						"'Economica', sans-serif" => "Economica",
						"'Quattrocento', serif" => "Quattrocento",
						"'Tinos', serif" => "Tinos",
						"'Courgette', handwriting" => "Courgette",
						"'Ruda', sans-serif" => "Ruda",
						"'Passion One', display" => "Passion One",
						"'Armata', sans-serif" => "Armata",
						"'Kreon', serif" => "Kreon",
						"'Permanent Marker', handwriting" => "Permanent Marker",
						"'Handlee', handwriting" => "Handlee",
						"'Archivo Black', sans-serif" => "Archivo Black",
						"'Didact Gothic', sans-serif" => "Didact Gothic",
						"'Kanit', sans-serif" => "Kanit",
						"'Philosopher', sans-serif" => "Philosopher",
						"'Cardo', serif" => "Cardo",
						"'Cantarell', sans-serif" => "Cantarell",
						"'Alfa Slab One', display" => "Alfa Slab One",
						"'Playfair Display SC', serif" => "Playfair Display SC",
						"'Cabin Condensed', sans-serif" => "Cabin Condensed",
						"'Antic Slab', serif" => "Antic Slab",
						"'Sintony', sans-serif" => "Sintony",
						"'Cookie', handwriting" => "Cookie",
						"'Ek Mukta', sans-serif" => "Ek Mukta",
						"'Arapey', serif" => "Arapey",
						"'Vidaloka', serif" => "Vidaloka",
						"'Playball', display" => "Playball",
						"'Droid Sans Mono', monospace" => "Droid Sans Mono",
						"'Days One', sans-serif" => "Days One",
						"'Bevan', display" => "Bevan",
						"'Tangerine', handwriting" => "Tangerine",
						"'Great Vibes', handwriting" => "Great Vibes",
						"'Rock Salt', handwriting" => "Rock Salt",
						"'Bangers', display" => "Bangers",
						"'Fredoka One', display" => "Fredoka One",
						"'Boogaloo', display" => "Boogaloo",
						"'Voltaire', sans-serif" => "Voltaire",
						"'Changa One', display" => "Changa One",
						"'Luckiest Guy', display" => "Luckiest Guy",
						"'Antic', sans-serif" => "Antic",
						"'Kalam', handwriting" => "Kalam",
						"'Shadows Into Light Two', handwriting" => "Shadows Into Light Two",
						"'Sorts Mill Goudy', serif" => "Sorts Mill Goudy",
						"'Amiri', serif" => "Amiri",
						"'Andada', serif" => "Andada",
						"'Audiowide', display" => "Audiowide",
						"'Varela', sans-serif" => "Varela",
						"'Actor', sans-serif" => "Actor",
						"'Rambla', sans-serif" => "Rambla",
						"'Adamina', serif" => "Adamina",
						"'Teko', sans-serif" => "Teko",
						"'Rajdhani', sans-serif" => "Rajdhani",
						"'Bad Script', handwriting" => "Bad Script",
						"'Nothing You Could Do', handwriting" => "Nothing You Could Do",
						"'Glegoo', serif" => "Glegoo",
						"'Volkhov', serif" => "Volkhov",
						"'Nobile', sans-serif" => "Nobile",
						"'Homemade Apple', handwriting" => "Homemade Apple",
						"'Neuton', serif" => "Neuton",
						"'Khand', sans-serif" => "Khand",
						"'Sarala', sans-serif" => "Sarala",
						"'Special Elite', display" => "Special Elite",
						"'Paytone One', sans-serif" => "Paytone One",
						"'Gentium Book Basic', serif" => "Gentium Book Basic",
						"'Molengo', sans-serif" => "Molengo",
						"'Unica One', display" => "Unica One",
						"'Alice', serif" => "Alice",
						"'Hind Siliguri', sans-serif" => "Hind Siliguri",
						"'Copse', serif" => "Copse",
						"'Amaranth', sans-serif" => "Amaranth",
						"'Montez', handwriting" => "Montez",
						"'Scada', sans-serif" => "Scada",
						"'Patrick Hand', handwriting" => "Patrick Hand",
						"'Homenaje', sans-serif" => "Homenaje",
						"'Sacramento', handwriting" => "Sacramento",
						"'Squada One', display" => "Squada One",
						"'Pragati Narrow', sans-serif" => "Pragati Narrow",
						"'Aldrich', sans-serif" => "Aldrich",
						"'Alex Brush', handwriting" => "Alex Brush",
						"'Damion', handwriting" => "Damion",
						"'VT323', monospace" => "VT323",
						"'Covered By Your Grace', handwriting" => "Covered By Your Grace",
						"'Calligraffitti', handwriting" => "Calligraffitti",
						"'Signika Negative', sans-serif" => "Signika Negative",
						"'Enriqueta', serif" => "Enriqueta",
						"'Jura', sans-serif" => "Jura",
						"'Gentium Basic', serif" => "Gentium Basic",
						"'Cambay', sans-serif" => "Cambay",
						"'Hind Vadodara', sans-serif" => "Hind Vadodara",
						"'Marmelad', sans-serif" => "Marmelad",
						"'Cantata One', serif" => "Cantata One",
						"'Pinyon Script', handwriting" => "Pinyon Script",
						"'Puritan', sans-serif" => "Puritan",
						"'Ultra', serif" => "Ultra",
						"'Alegreya Sans SC', sans-serif" => "Alegreya Sans SC",
						"'Electrolize', sans-serif" => "Electrolize",
						"'Oleo Script', display" => "Oleo Script",
						"'Candal', sans-serif" => "Candal",
						"'Fugaz One', display" => "Fugaz One",
						"'Viga', sans-serif" => "Viga",
						"'Neucha', handwriting" => "Neucha",
						"'Fauna One', serif" => "Fauna One",
						"'Gochi Hand', handwriting" => "Gochi Hand",
						"'Khula', sans-serif" => "Khula",
						"'PT Mono', monospace" => "PT Mono",
						"'Sigmar One', display" => "Sigmar One",
						"'Cherry Cream Soda', display" => "Cherry Cream Soda",
						"'Julius Sans One', sans-serif" => "Julius Sans One",
						"'Carme', sans-serif" => "Carme",
						"'Rancho', handwriting" => "Rancho",
						"'Hanuman', serif" => "Hanuman",
						"'Overlock', display" => "Overlock",
						"'Racing Sans One', display" => "Racing Sans One",
						"'Share', display" => "Share",
						"'Basic', sans-serif" => "Basic",
						"'Just Another Hand', handwriting" => "Just Another Hand",
						"'Coda', display" => "Coda",
						"'Ceviche One', display" => "Ceviche One",
						"'Marck Script', handwriting" => "Marck Script",
						"'Mate', serif" => "Mate",
						"'Chivo', sans-serif" => "Chivo",
						"'Lusitana', serif" => "Lusitana",
						"'Niconne', handwriting" => "Niconne",
						"'Prata', serif" => "Prata",
						"'Arbutus Slab', serif" => "Arbutus Slab",
						"'Ubuntu Mono', monospace" => "Ubuntu Mono",
						"'Allura', handwriting" => "Allura",
						"'Black Ops One', display" => "Black Ops One",
						"'Allerta Stencil', sans-serif" => "Allerta Stencil",
						"'Lustria', serif" => "Lustria",
						"'Allerta', sans-serif" => "Allerta",
						"'Michroma', sans-serif" => "Michroma",
						"'PT Serif Caption', serif" => "PT Serif Caption",
						"'Kameron', serif" => "Kameron",
						"'Telex', sans-serif" => "Telex",
						"'Fanwood Text', serif" => "Fanwood Text",
						"'Cabin Sketch', display" => "Cabin Sketch",
						"'Montserrat Alternates', sans-serif" => "Montserrat Alternates",
						"'Advent Pro', sans-serif" => "Advent Pro",
						"'Freckle Face', display" => "Freckle Face",
						"'Syncopate', sans-serif" => "Syncopate",
						"'Schoolbell', handwriting" => "Schoolbell",
						"'Crafty Girls', handwriting" => "Crafty Girls",
						"'Nixie One', display" => "Nixie One",
						"'Reenie Beanie', handwriting" => "Reenie Beanie",
						"'Spinnaker', sans-serif" => "Spinnaker",
						"'Jockey One', sans-serif" => "Jockey One",
						"'Average', serif" => "Average",
						"'Convergence', sans-serif" => "Convergence",
						"'Marvel', sans-serif" => "Marvel",
						"'Limelight', display" => "Limelight",
						"'Yantramanav', sans-serif" => "Yantramanav",
						"'Marcellus', serif" => "Marcellus",
						"'Bubblegum Sans', display" => "Bubblegum Sans",
						"'Alef', sans-serif" => "Alef",
						"'Oranienbaum', serif" => "Oranienbaum",
						"'Parisienne', handwriting" => "Parisienne",
						"'Carrois Gothic', sans-serif" => "Carrois Gothic",
						"'Rochester', handwriting" => "Rochester",
						"'Quantico', sans-serif" => "Quantico",
						"'Average Sans', sans-serif" => "Average Sans",
						"'Doppio One', sans-serif" => "Doppio One",
						"'Contrail One', display" => "Contrail One",
						"'Fontdiner Swanky', display" => "Fontdiner Swanky",
						"'Martel', serif" => "Martel",
						"'Just Me Again Down Here', handwriting" => "Just Me Again Down Here",
						"'Yesteryear', handwriting" => "Yesteryear",
						"'Sree Krushnadevaraya', serif" => "Sree Krushnadevaraya",
						"'Grand Hotel', handwriting" => "Grand Hotel",
						"'Walter Turncoat', handwriting" => "Walter Turncoat",
						"'Merienda', handwriting" => "Merienda",
						"'Six Caps', sans-serif" => "Six Caps",
						"'Ruslan Display', display" => "Ruslan Display",
						"'Coustard', serif" => "Coustard",
						"'Goudy Bookletter 1911', serif" => "Goudy Bookletter 1911",
						"'Chelsea Market', display" => "Chelsea Market",
						"'Cormorant Garamond', serif" => "Cormorant Garamond",
						"'Sue Ellen Francisco', handwriting" => "Sue Ellen Francisco",
						"'Waiting for the Sunrise', handwriting" => "Waiting for the Sunrise",
						"'Magra', sans-serif" => "Magra",
						"'Aclonica', sans-serif" => "Aclonica",
						"'Sansita One', display" => "Sansita One",
						"'Annie Use Your Telescope', handwriting" => "Annie Use Your Telescope",
						"'Alegreya SC', serif" => "Alegreya SC",
						"'Halant', serif" => "Halant",
						"'Cutive', serif" => "Cutive",
						"'Marcellus SC', serif" => "Marcellus SC",
						"'Jaldi', sans-serif" => "Jaldi",
						"'Leckerli One', handwriting" => "Leckerli One",
						"'Rosario', sans-serif" => "Rosario",
						"'Carter One', display" => "Carter One",
						"'Fredericka the Great', display" => "Fredericka the Great",
						"'Berkshire Swash', handwriting" => "Berkshire Swash",
						"'Cousine', monospace" => "Cousine",
						"'Libre Franklin', sans-serif" => "Libre Franklin",
						"'Tauri', sans-serif" => "Tauri",
						"'Allan', display" => "Allan",
						"'Press Start 2P', display" => "Press Start 2P",
						"'Radley', serif" => "Radley",
						"'Graduate', display" => "Graduate",
						"'Slackey', display" => "Slackey",
						"'Corben', display" => "Corben",
						"'Metrophobic', sans-serif" => "Metrophobic",
						"'Gilda Display', serif" => "Gilda Display",
						"'Anaheim', sans-serif" => "Anaheim",
						"'Oxygen Mono', monospace" => "Oxygen Mono",
						"'Forum', display" => "Forum",
						"'Trocchi', serif" => "Trocchi",
						"'Slabo 13px', serif" => "Slabo 13px",
						"'Merienda One', handwriting" => "Merienda One",
						"'Cairo', sans-serif" => "Cairo",
						"'Monoton', display" => "Monoton",
						"'Duru Sans', sans-serif" => "Duru Sans",
						"'Port Lligat Slab', serif" => "Port Lligat Slab",
						"'Caudex', serif" => "Caudex",
						"'Happy Monkey', display" => "Happy Monkey",
						"'Oleo Script Swash Caps', display" => "Oleo Script Swash Caps",
						"'Italianno', handwriting" => "Italianno",
						"'Lekton', sans-serif" => "Lekton",
						"'Gruppo', display" => "Gruppo",
						"'Averia Serif Libre', display" => "Averia Serif Libre",
						"'Palanquin', sans-serif" => "Palanquin",
						"'Mako', sans-serif" => "Mako",
						"'Give You Glory', handwriting" => "Give You Glory",
						"'Belleza', sans-serif" => "Belleza",
						"'Capriola', sans-serif" => "Capriola",
						"'Anonymous Pro', monospace" => "Anonymous Pro",
						"'Pompiere', display" => "Pompiere",
						"'Short Stack', handwriting" => "Short Stack",
						"'Lilita One', display" => "Lilita One",
						"'Petit Formal Script', handwriting" => "Petit Formal Script",
						"'Cinzel Decorative', display" => "Cinzel Decorative",
						"'Bowlby One SC', display" => "Bowlby One SC",
						"'The Girl Next Door', handwriting" => "The Girl Next Door",
						"'Caveat', handwriting" => "Caveat",
						"'Ovo', serif" => "Ovo",
						"'Frijole', display" => "Frijole",
						"'Inder', sans-serif" => "Inder",
						"'Lateef', handwriting" => "Lateef",
						"'Lemon', display" => "Lemon",
						"'Tenor Sans', sans-serif" => "Tenor Sans",
						"'Quando', serif" => "Quando",
						"'Baumans', display" => "Baumans",
						"'Unkempt', display" => "Unkempt",
						"'Kelly Slab', display" => "Kelly Slab",
						"'Brawler', serif" => "Brawler",
						"'Clicker Script', handwriting" => "Clicker Script",
						"'Titan One', display" => "Titan One",
						"'Strait', sans-serif" => "Strait",
						"'Rufina', serif" => "Rufina",
						"'Kranky', display" => "Kranky",
						"'Andika', sans-serif" => "Andika",
						"'Zeyada', handwriting" => "Zeyada",
						"'Wire One', sans-serif" => "Wire One",
						"'Crushed', display" => "Crushed",
						"'Concert One', display" => "Concert One",
						"'Delius', handwriting" => "Delius",
						"'Cutive Mono', monospace" => "Cutive Mono",
						"'Alike', serif" => "Alike",
						"'Khmer', display" => "Khmer",
						"'Love Ya Like A Sister', display" => "Love Ya Like A Sister",
						"'Oregano', display" => "Oregano",
						"'Prosto One', display" => "Prosto One",
						"'Mr Dafoe', handwriting" => "Mr Dafoe",
						"'Kurale', serif" => "Kurale",
						"'Judson', serif" => "Judson",
						"'Aladin', handwriting" => "Aladin",
						"'Gravitas One', display" => "Gravitas One",
						"'Karma', serif" => "Karma",
						"'Biryani', sans-serif" => "Biryani",
						"'Herr Von Muellerhoff', handwriting" => "Herr Von Muellerhoff",
						"'Eczar', serif" => "Eczar",
						"'Finger Paint', display" => "Finger Paint",
						"'Londrina Solid', display" => "Londrina Solid",
						"'Denk One', sans-serif" => "Denk One",
						"'Orienta', sans-serif" => "Orienta",
						"'Knewave', display" => "Knewave",
						"'IM Fell DW Pica', serif" => "IM Fell DW Pica",
						"'GFS Didot', serif" => "GFS Didot",
						"'Bentham', serif" => "Bentham",
						"'Shojumaru', display" => "Shojumaru",
						"'Voces', display" => "Voces",
						"'Skranji', display" => "Skranji",
						"'Sniglet', display" => "Sniglet",
						"'Poly', serif" => "Poly",
						"'UnifrakturMaguntia', display" => "UnifrakturMaguntia",
						"'Timmana', sans-serif" => "Timmana",
						"'La Belle Aurore', handwriting" => "La Belle Aurore",
						"'IM Fell English', serif" => "IM Fell English",
						"'Quintessential', handwriting" => "Quintessential",
						"'Holtwood One SC', serif" => "Holtwood One SC",
						"'Yeseva One', display" => "Yeseva One",
						"'Stardos Stencil', display" => "Stardos Stencil",
						"'Bowlby One', display" => "Bowlby One",
						"'Dorsa', sans-serif" => "Dorsa",
						"'Nova Square', display" => "Nova Square",
						"'Headland One', serif" => "Headland One",
						"'Expletus Sans', display" => "Expletus Sans",
						"'Fenix', serif" => "Fenix",
						"'Caveat Brush', handwriting" => "Caveat Brush",
						"'Gabriela', serif" => "Gabriela",
						"'Lily Script One', display" => "Lily Script One",
						"'Heebo', sans-serif" => "Heebo",
						"'McLaren', display" => "McLaren",
						"'Qwigley', handwriting" => "Qwigley",
						"'Londrina Outline', display" => "Londrina Outline",
						"'Itim', handwriting" => "Itim",
						"'Cherry Swash', display" => "Cherry Swash",
						"'Norican', handwriting" => "Norican",
						"'Belgrano', serif" => "Belgrano",
						"'Angkor', display" => "Angkor",
						"'Imprima', sans-serif" => "Imprima",
						"'Martel Sans', sans-serif" => "Martel Sans",
						"'Gafata', sans-serif" => "Gafata",
						"'Rationale', sans-serif" => "Rationale",
						"'NTR', sans-serif" => "NTR",
						"'Megrim', display" => "Megrim",
						"'Salsa', display" => "Salsa",
						"'Bilbo Swash Caps', handwriting" => "Bilbo Swash Caps",
						"'Simonetta', display" => "Simonetta",
						"'Kotta One', serif" => "Kotta One",
						"'Fjord One', serif" => "Fjord One",
						"'Arizonia', handwriting" => "Arizonia",
						"'Loved by the King', handwriting" => "Loved by the King",
						"'Seaweed Script', display" => "Seaweed Script",
						"'Rammetto One', display" => "Rammetto One",
						"'Federo', sans-serif" => "Federo",
						"'Prompt', sans-serif" => "Prompt",
						"'Patrick Hand SC', handwriting" => "Patrick Hand SC",
						"'Kristi', handwriting" => "Kristi",
						"'Shanti', sans-serif" => "Shanti",
						"'Averia Sans Libre', display" => "Averia Sans Libre",
						"'Fira Mono', monospace" => "Fira Mono",
						"'Tienne', serif" => "Tienne",
						"'Carrois Gothic SC', sans-serif" => "Carrois Gothic SC",
						"'Unna', serif" => "Unna",
						"'Podkova', serif" => "Podkova",
						"'Mountains of Christmas', display" => "Mountains of Christmas",
						"'Life Savers', display" => "Life Savers",
						"'Delius Swash Caps', handwriting" => "Delius Swash Caps",
						"'Share Tech', sans-serif" => "Share Tech",
						"'Balthazar', serif" => "Balthazar",
						"'Over the Rainbow', handwriting" => "Over the Rainbow",
						"'Coda Caption', sans-serif" => "Coda Caption",
						"'Engagement', handwriting" => "Engagement",
						"'Dawning of a New Day', handwriting" => "Dawning of a New Day",
						"'Suwannaphum', display" => "Suwannaphum",
						"'Chau Philomene One', sans-serif" => "Chau Philomene One",
						"'Italiana', serif" => "Italiana",
						"'Stalemate', handwriting" => "Stalemate",
						"'IM Fell English SC', serif" => "IM Fell English SC",
						"'Meddon', handwriting" => "Meddon",
						"'Mr De Haviland', handwriting" => "Mr De Haviland",
						"'Amethysta', serif" => "Amethysta",
						"'Bokor', display" => "Bokor",
						"'Mouse Memoirs', sans-serif" => "Mouse Memoirs",
						"'Euphoria Script', handwriting" => "Euphoria Script",
						"'Cambo', serif" => "Cambo",
						"'Nokora', serif" => "Nokora",
						"'Fondamento', handwriting" => "Fondamento",
						"'Ruthie', handwriting" => "Ruthie",
						"'Geo', sans-serif" => "Geo",
						"'Mallanna', sans-serif" => "Mallanna",
						"'Nova Mono', monospace" => "Nova Mono",
						"'Cantora One', sans-serif" => "Cantora One",
						"'Codystar', display" => "Codystar",
						"'Raleway Dots', display" => "Raleway Dots",
						"'Ramabhadra', sans-serif" => "Ramabhadra",
						"'Vast Shadow', display" => "Vast Shadow",
						"'Share Tech Mono', monospace" => "Share Tech Mono",
						"'Sail', display" => "Sail",
						"'Ledger', serif" => "Ledger",
						"'Rouge Script', handwriting" => "Rouge Script",
						"'Chonburi', display" => "Chonburi",
						"'Assistant', sans-serif" => "Assistant",
						"'Mate SC', serif" => "Mate SC",
						"'Vibur', handwriting" => "Vibur",
						"'Ramaraja', serif" => "Ramaraja",
						"'Aguafina Script', handwriting" => "Aguafina Script",
						"'Sofia', handwriting" => "Sofia",
						"'Cedarville Cursive', handwriting" => "Cedarville Cursive",
						"'IM Fell Double Pica', serif" => "IM Fell Double Pica",
						"'Creepster', display" => "Creepster",
						"'Kite One', sans-serif" => "Kite One",
						"'Milonga', display" => "Milonga",
						"'Buenard', serif" => "Buenard",
						"'Metamorphous', display" => "Metamorphous",
						"'Stoke', serif" => "Stoke",
						"'Trirong', serif" => "Trirong",
						"'Moul', display" => "Moul",
						"'IM Fell French Canon', serif" => "IM Fell French Canon",
						"'Chicle', display" => "Chicle",
						"'Maiden Orange', display" => "Maiden Orange",
						"'Gurajada', serif" => "Gurajada",
						"'Sumana', serif" => "Sumana",
						"'Odor Mean Chey', display" => "Odor Mean Chey",
						"'Irish Grover', display" => "Irish Grover",
						"'Battambang', display" => "Battambang",
						"'Oldenburg', display" => "Oldenburg",
						"'Flamenco', display" => "Flamenco",
						"'Englebert', sans-serif" => "Englebert",
						"'Medula One', display" => "Medula One",
						"'Rye', display" => "Rye",
						"'Inika', serif" => "Inika",
						"'Suez One', serif" => "Suez One",
						"'Almendra', serif" => "Almendra",
						"'Numans', sans-serif" => "Numans",
						"'Text Me One', sans-serif" => "Text Me One",
						"'Wallpoet', display" => "Wallpoet",
						"'Dynalight', display" => "Dynalight",
						"'Krona One', sans-serif" => "Krona One",
						"'Donegal One', serif" => "Donegal One",
						"'Baloo Bhai', display" => "Baloo Bhai",
						"'Swanky and Moo Moo', handwriting" => "Swanky and Moo Moo",
						"'Artifika', serif" => "Artifika",
						"'Amarante', display" => "Amarante",
						"'Revalia', display" => "Revalia",
						"'Condiment', handwriting" => "Condiment",
						"'Stint Ultra Expanded', display" => "Stint Ultra Expanded",
						"'Sonsie One', display" => "Sonsie One",
						"'IM Fell DW Pica SC', serif" => "IM Fell DW Pica SC",
						"'Prociono', serif" => "Prociono",
						"'Tulpen One', display" => "Tulpen One",
						"'Poller One', display" => "Poller One",
						"'Miniver', display" => "Miniver",
						"'Habibi', serif" => "Habibi",
						"'Esteban', serif" => "Esteban",
						"'Rosarivo', serif" => "Rosarivo",
						"'Sunshiney', handwriting" => "Sunshiney",
						"'IM Fell French Canon SC', serif" => "IM Fell French Canon SC",
						"'Junge', serif" => "Junge",
						"'Lalezar', display" => "Lalezar",
						"'IM Fell Great Primer', serif" => "IM Fell Great Primer",
						"'Stint Ultra Condensed', display" => "Stint Ultra Condensed",
						"'Scheherazade', serif" => "Scheherazade",
						"'Chango', display" => "Chango",
						"'Nosifer', display" => "Nosifer",
						"'Monofett', display" => "Monofett",
						"'League Script', handwriting" => "League Script",
						"'Rubik One', sans-serif" => "Rubik One",
						"'Kavoon', display" => "Kavoon",
						"'Ruluko', sans-serif" => "Ruluko",
						"'Montserrat Subrayada', sans-serif" => "Montserrat Subrayada",
						"'Vesper Libre', serif" => "Vesper Libre",
						"'Spicy Rice', display" => "Spicy Rice",
						"'Linden Hill', serif" => "Linden Hill",
						"'Trade Winds', display" => "Trade Winds",
						"'Alike Angular', serif" => "Alike Angular",
						"'Paprika', display" => "Paprika",
						"'Sancreek', display" => "Sancreek",
						"'Changa', sans-serif" => "Changa",
						"'Overlock SC', display" => "Overlock SC",
						"'IM Fell Great Primer SC', serif" => "IM Fell Great Primer SC",
						"'Griffy', display" => "Griffy",
						"'Delius Unicase', handwriting" => "Delius Unicase",
						"'Averia Libre', display" => "Averia Libre",
						"'Baloo', display" => "Baloo",
						"'IM Fell Double Pica SC', serif" => "IM Fell Double Pica SC",
						"'Dekko', handwriting" => "Dekko",
						"'Elsie', display" => "Elsie",
						"'Buda', display" => "Buda",
						"'Piedra', display" => "Piedra",
						"'Offside', display" => "Offside",
						"'Baloo Thambi', display" => "Baloo Thambi",
						"'Cagliostro', sans-serif" => "Cagliostro",
						"'Baloo Da', display" => "Baloo Da",
						"'Secular One', sans-serif" => "Secular One",
						"'Nova Round', display" => "Nova Round",
						"'Bilbo', handwriting" => "Bilbo",
						"'Mystery Quest', display" => "Mystery Quest",
						"'New Rocker', display" => "New Rocker",
						"'Port Lligat Sans', sans-serif" => "Port Lligat Sans",
						"'Henny Penny', display" => "Henny Penny",
						"'Faster One', display" => "Faster One",
						"'Ribeye', display" => "Ribeye",
						"'Redressed', handwriting" => "Redressed",
						"'Athiti', sans-serif" => "Athiti",
						"'Antic Didone', serif" => "Antic Didone",
						"'Mandali', sans-serif" => "Mandali",
						"'Iceland', display" => "Iceland",
						"'Nova Slim', display" => "Nova Slim",
						"'Bigshot One', display" => "Bigshot One",
						"'Mrs Saint Delafield', handwriting" => "Mrs Saint Delafield",
						"'Asul', sans-serif" => "Asul",
						"'Suranna', serif" => "Suranna",
						"'Sarpanch', sans-serif" => "Sarpanch",
						"'Petrona', serif" => "Petrona",
						"'Glass Antiqua', display" => "Glass Antiqua",
						"'Content', display" => "Content",
						"'Baloo Paaji', display" => "Baloo Paaji",
						"'Margarine', display" => "Margarine",
						"'MedievalSharp', display" => "MedievalSharp",
						"'Autour One', display" => "Autour One",
						"'Snippet', sans-serif" => "Snippet",
						"'Akronim', display" => "Akronim",
						"'Wendy One', sans-serif" => "Wendy One",
						"'Iceberg', display" => "Iceberg",
						"'Julee', handwriting" => "Julee",
						"'Germania One', display" => "Germania One",
						"'Mitr', sans-serif" => "Mitr",
						"'Emilys Candy', display" => "Emilys Candy",
						"'Della Respira', serif" => "Della Respira",
						"'Fascinate', display" => "Fascinate",
						"'Bubbler One', sans-serif" => "Bubbler One",
						"'Sarina', display" => "Sarina",
						"'UnifrakturCook', display" => "UnifrakturCook",
						"'Sriracha', handwriting" => "Sriracha",
						"'Wellfleet', display" => "Wellfleet",
						"'Galindo', display" => "Galindo",
						"'Almendra SC', serif" => "Almendra SC",
						"'Nova Flat', display" => "Nova Flat",
						"'Asset', display" => "Asset",
						"'Pirata One', display" => "Pirata One",
						"'Croissant One', display" => "Croissant One",
						"'Baloo Bhaina', display" => "Baloo Bhaina",
						"'Joti One', display" => "Joti One",
						"'Laila', serif" => "Laila",
						"'Miriam Libre', sans-serif" => "Miriam Libre",
						"'Miltonian Tattoo', display" => "Miltonian Tattoo",
						"'Averia Gruesa Libre', display" => "Averia Gruesa Libre",
						"'Modern Antiqua', display" => "Modern Antiqua",
						"'El Messiri', sans-serif" => "El Messiri",
						"'Rozha One', serif" => "Rozha One",
						"'Trykker', serif" => "Trykker",
						"'Kenia', display" => "Kenia",
						"'Monsieur La Doulaise', handwriting" => "Monsieur La Doulaise",
						"'Peralta', display" => "Peralta",
						"'Astloch', display" => "Astloch",
						"'Jacques Francois', serif" => "Jacques Francois",
						"'Smythe', display" => "Smythe",
						"'Snowburst One', display" => "Snowburst One",
						"'Frank Ruhl Libre', sans-serif" => "Frank Ruhl Libre",
						"'GFS Neohellenic', sans-serif" => "GFS Neohellenic",
						"'David Libre', serif" => "David Libre",
						"'Montaga', serif" => "Montaga",
						"'Meie Script', handwriting" => "Meie Script",
						"'Sura', serif" => "Sura",
						"'Lovers Quarrel', handwriting" => "Lovers Quarrel",
						"'Atomic Age', display" => "Atomic Age",
						"'Fresca', sans-serif" => "Fresca",
						"'Kadwa', serif" => "Kadwa",
						"'Jolly Lodger', display" => "Jolly Lodger",
						"'Trochut', display" => "Trochut",
						"'Dr Sugiyama', handwriting" => "Dr Sugiyama",
						"'Lancelot', display" => "Lancelot",
						"'Amatica SC', display" => "Amatica SC",
						"'Ranchers', display" => "Ranchers",
						"'Nova Oval', display" => "Nova Oval",
						"'Jacques Francois Shadow', display" => "Jacques Francois Shadow",
						"'Eagle Lake', handwriting" => "Eagle Lake",
						"'Arya', sans-serif" => "Arya",
						"'Warnes', display" => "Warnes",
						"'Freehand', display" => "Freehand",
						"'Galdeano', sans-serif" => "Galdeano",
						"'Vampiro One', display" => "Vampiro One",
						"'Baloo Tamma', display" => "Baloo Tamma",
						"'Hind Guntur', sans-serif" => "Hind Guntur",
						"'Amiko', sans-serif" => "Amiko",
						"'Keania One', display" => "Keania One",
						"'Palanquin Dark', sans-serif" => "Palanquin Dark",
						"'Passero One', display" => "Passero One",
						"'Ranga', display" => "Ranga",
						"'Rum Raisin', sans-serif" => "Rum Raisin",
						"'Kdam Thmor', display" => "Kdam Thmor",
						"'Goblin One', display" => "Goblin One",
						"'Gidugu', sans-serif" => "Gidugu",
						"'Amita', handwriting" => "Amita",
						"'Miltonian', display" => "Miltonian",
						"'Diplomata', display" => "Diplomata",
						"'Elsie Swash Caps', display" => "Elsie Swash Caps",
						"'Gorditas', display" => "Gorditas",
						"'Baloo Chettan', display" => "Baloo Chettan",
						"'Dangrek', display" => "Dangrek",
						"'Kantumruy', sans-serif" => "Kantumruy",
						"'Caesar Dressing', display" => "Caesar Dressing",
						"'Shrikhand', display" => "Shrikhand",
						"'Nova Cut', display" => "Nova Cut",
						"'Harmattan', sans-serif" => "Harmattan",
						"'Londrina Shadow', display" => "Londrina Shadow",
						"'Devonshire', handwriting" => "Devonshire",
						"'Romanesco', handwriting" => "Romanesco",
						"'Nova Script', display" => "Nova Script",
						"'Original Surfer', display" => "Original Surfer",
						"'Rhodium Libre', serif" => "Rhodium Libre",
						"'Felipa', handwriting" => "Felipa",
						"'Rubik Mono One', sans-serif" => "Rubik Mono One",
						"'Macondo Swash Caps', display" => "Macondo Swash Caps"					
					),
					'inherit',
					__('Set an font family','yp')
				)."
				
				
				".yp_get_select_markup(
					'font-weight',
					__('Font Weight','yp')
					,array(
						'300' => __('Light',"yp").' 300',
						'400' => __('normal',"yp").' 400',
						'500' => __('Semi-Bold',"yp").' 500',
						'600' => __('Bold',"yp").' 600',
						'700' => __('Extra-Bold',"yp").' 700'
					),
					'inherit',
					__('Set the font family','yp')
				)."
	
				".yp_get_color_markup(
					'color',
					__('Color','yp'),
					'Set the text color'
				)."

				".yp_get_select_markup(
					'text-shadow',
					__('Text Shadow','yp')
					,array(
						'none' => 'none',
						'rgba(0, 0, 0, 0.3) 0px 1px 1px' => 'Basic Shadow',
						'rgb(255, 255, 255) 1px 1px 0px, rgb(170, 170, 170) 2px 2px 0px' => 'Shadow Multiple',
						'rgb(255, 0, 0) -1px 0px 0px, rgb(0, 255, 255) 1px 0px 0px' => 'Anaglyph',
						'rgb(255, 255, 255) 0px 1px 1px, rgb(0, 0, 0) 0px -1px 1px' => 'Emboss',
						'rgb(255, 255, 255) 0px 0px 2px, rgb(255, 255, 255) 0px 0px 4px, rgb(255, 255, 255) 0px 0px 6px, rgb(255, 119, 255) 0px 0px 8px, rgb(255, 0, 255) 0px 0px 12px, rgb(255, 0, 255) 0px 0px 16px, rgb(255, 0, 255) 0px 0px 20px, rgb(255, 0, 255) 0px 0px 24px' => 'Neon',
						'rgb(0, 0, 0) 0px 1px 1px, rgb(0, 0, 0) 0px -1px 1px, rgb(0, 0, 0) 1px 0px 1px, rgb(0, 0, 0) -1px 0px 1px' => 'Outline'
					),
					'none'
				)."

				".yp_get_slider_markup(
					'font-size',
					__('Font Size','yp'),
					'inherit',
					0,        // decimals
					'8,100',   // px value
					'0,100',  // percentage value
					'1,6'     // Em value
				)."
				
				".yp_get_slider_markup(
					'line-height',
					__('Line Height','yp'),
					'inherit',
					1,        // decimals
					'0,100',   // px value
					'0,100',  // percentage value
					'1,6',     // Em value,
					__('Set the leading','yp')
				)."
				
				".yp_get_radio_markup(
					'font-style',
					__('Font Style','yp'),
					array(
						'normal' => __('Normal','yp'),
						'italic' => __('Italic','yp')
					),
					'inherit'
				)."

				".yp_get_radio_markup(
					'text-align',
					__('Text Align','yp'),
					array(
						'left' => __('left','yp'),
						'center' => __('center','yp'),
						'right' => __('right','yp'),
						'justify' => __('justify','yp')
					),
					'start'
				)."
				
				".yp_get_radio_markup(
					'text-transform',
					__('Text Transform','yp'),
					array(
						'uppercase' => __('upprcase','yp'),
						'lowercase' => __('lowercase','yp'),
						'capitalize' => __('capitalize','yp')
					),
					'none'						
				)."
			
				
				".yp_get_slider_markup(
					'letter-spacing',
					__('Letter Spacing','yp'),
					'inherit',
					1,        // decimals
					'-5,10',   // px value
					'0,100',  // percentage value
					'-1,3'     // Em value
				)."
				
				".yp_get_slider_markup(
					'word-spacing',
					__('Word Spacing','yp'),
					'inherit',
					1,        // decimals
					'-5,20',   // px value
					'0,100',  // percentage value
					'-1,3'     // Em value,
				)."

				".yp_get_radio_markup(
					'text-decoration',
					__('text Decoration','yp'),
					array(
						'overline' => __('overline','yp'),
						'line-through' => __('through','yp'),
						'underline' => __('underline','yp')
					),
					'none'
				)."
				
			</div>
		</li>
		
		<li class='background-option'>
			<h3>".__('Background','yp')." ".yp_arrow_icon()."</h3>
			<div class='yp-this-content'>
			
				<a class='yp-advanced-link yp-top yp-special-css-link yp-just-desktop yp-parallax-link'>".__('Background Parallax','yp')."</a>
				<div class='yp-advanced-option yp-special-css-area yp-just-desktop background-parallax-div'>

					<div class='little-break yp-lite'></div>

					".yp_get_radio_markup( // Special CSS
						'background-parallax',
						__('Effect Status','yp'),
						array(
							'true' => __('Enable','yp'),
							'disable' => __('Disable','yp')
						),
						false						
					)."
					
					".yp_get_slider_markup(
						'background-parallax-speed',
						__('Parallax Speed','yp'),
						'',
						2,        // decimals
						'1,10',   // px value
						'1,10',  // percentage value
						'1,10'     // Em value
					)."
					
					".yp_get_slider_markup(
						'background-parallax-x',
						__('Parallax Position X','yp'),
						'',
						2,        // decimals
						'1,100',   // px value
						'1,100',  // percentage value
						'1,100'     // Em value
					)."
					
				</div>
				
				".yp_get_color_markup(
					'background-color',
					__('Background Color','yp')
				)."
				
				".yp_get_input_markup(
					'background-image',
					__('Background Image','yp'),
					'none'
				)."

				".yp_get_radio_markup(
					'background-blend-mode',
					__('BG. Blend Mode','yp'),
					array(
						'multiply' => __('multiply','yp'),
						'darken' => __('darken','yp'),
						'luminosity' => __('luminosity','yp')			
					),
					'normal',
					__('Mix the background color with the background image.','yp')
				)."

				".yp_get_select_markup(
					'background-position',
					__('BG. Position','yp'),
					array(
						'0% 0%' => __('left top','yp'),
						'0% 50%' => __('left center','yp'),
						'0% 100%' => __('left bottom','yp'),
						'100% 0%' => __('right top','yp'),
						'100% 50%' => __('right center','yp'),
						'100% 100%' => __('right bottom','yp'),
						'50% 0%' => __('center top','yp'),
						'50% 50%' => __('center center','yp'),
						'50% 100%' => __('center bottom','yp')
					),
					'0% 0%',
					__('Sets the starting position of a background image','yp')
				)."

				".yp_get_radio_markup(
					'background-size',
					__('Background Size','yp'),
					array(
						'length' => __('length','yp'),
						'cover' => __('cover','yp'),
						'contain' => __('contain','yp')
					),
					'auto auto',
					__('The size of the background image','yp')
				)."				
				
				".yp_get_radio_markup(
					'background-repeat',
					__('Background Repeat','yp'),
					array(
						'repeat-x' => __('repeat-x','yp'),
						'repeat-y' => __('repeat-y','yp'),
						'no-repeat' => __('no-repeat','yp')
					),
					'repeat',
					__('Sets if background image will be repeated','yp')
				)."
				
				".yp_get_radio_markup(
					'background-attachment',
					__('BG. Attachment','yp'),
					array(
						'fixed' => __('fixed','yp'),
						'local' => __('local','yp')
					),
					'scroll',
					__('Sets whether a background image is fixed or scrolls with the rest of the page','yp')
				)."				
				
			</div>
		</li>
		
		<li class='margin-option'>
			<h3>".__('Margin','yp')." ".yp_arrow_icon()."</h3>
			<div class='yp-this-content'>

				<div class='lock-btn'></div>

				".yp_get_slider_markup(
					'margin-left',
					__('Margin Left','yp'),
					'auto',
					0,        // decimals
					'-50,200',   // px value
					'-100,100',  // percentage value
					'-6,26',     // Em value,
					__('The margin clears an area around an element. The margin does not have a background color, and is completely transparent.','yp')
				)."
				
				".yp_get_slider_markup(
					'margin-right',
					__('Margin Right','yp'),
					'auto',
					0,        // decimals
					'-50,200',   // px value
					'-100,100',  // percentage value
					'-6,26',     // Em value
					__('The margin clears an area around an element. The margin does not have a background color, and is completely transparent.','yp')
				)."

				".yp_get_slider_markup(
					'margin-top',
					__('Margin Top','yp'),
					'auto',
					0,        // decimals
					'-50,200',   // px value
					'-100,100',  // percentage value
					'-6,26',     // Em value
					__('The margin clears an area around an element. The margin does not have a background color, and is completely transparent.','yp')
				)."
				
				".yp_get_slider_markup(
					'margin-bottom',
					__('Margin Bottom','yp'),
					'auto',
					0,        // decimals
					'-50,200',   // px value
					'-100,100',  // percentage value
					'-6,26',     // Em value
					__('The margin clears an area around an element. The margin does not have a background color, and is completely transparent.','yp')
				)."
				
				
				
			</div>
		</li>
		
		<li class='padding-option'>
			<h3>".__('Padding','yp')." ".yp_arrow_icon()."</h3>
			<div class='yp-this-content'>
				
				<div class='lock-btn'></div>

				".yp_get_slider_markup(
					'padding-left',
					__('Padding Left','yp'),
					'',
					0,        // decimals
					'0,200',   // px value
					'0,100',  // percentage value
					'0,26',     // Em value
					__('The padding clears an area around the content of an element. The padding is affected by the background color of the element.','yp')
				)."

				".yp_get_slider_markup(
					'padding-right',
					__('Padding Right','yp'),
					'',
					0,        // decimals
					'0,200',   // px value
					'0,100',  // percentage value
					'0,26',     // Em value
					__('The padding clears an area around the content of an element. The padding is affected by the background color of the element.','yp')
				)."

				".yp_get_slider_markup(
					'padding-top',
					__('Padding Top','yp'),
					'',
					0,        // decimals
					'0,200',   // px value
					'0,100',  // percentage value
					'0,26',     // Em value
					__('The padding clears an area around the content of an element. The padding is affected by the background color of the element.','yp')
				)."
				
				".yp_get_slider_markup(
					'padding-bottom',
					__('Padding Bottom','yp'),
					'',
					0,        // decimals
					'0,200',   // px value
					'0,100',  // percentage value
					'0,26',     // Em value
					__('The padding clears an area around the content of an element. The padding is affected by the background color of the element.','yp')
				)."

				
				
			
			</div>
		</li>

		
		<li class='border-option'>
			<h3>".__('Border','yp')." ".yp_arrow_icon()."</h3>
			<div class='yp-this-content'>
				
				
				".yp_get_radio_markup(
					'border-style',
					__('Border Style','yp'),
					array(
						'solid' => __('solid','yp'),
						'dotted' => __('dotted','yp'),
						'dashed' => __('dashed','yp'),
						'hidden' => __('hidden','yp')
					),
					'none',
					__('Sets the style of an elements four borders. This property can have from one to four values.','yp')
				)."
				
				
				".yp_get_slider_markup(
					'border-width',
					__('Border Width','yp'),
					'',
					0,        // decimals
					'0,20',   // px value
					'0,100',  // percentage value
					'0,3',     // Em value
					__('Sets the width of an elements four borders. This property can have from one to four values.','yp')
				)."
				
				".yp_get_color_markup(
					'border-color',
					__('Border Color','yp'),
					__('Sets the color of an elements four borders.','yp')
				)."
				
				
				<a class='yp-advanced-link yp-special-css-link yp-border-special'>".__('Border Top','yp')."</a>
				<div class='yp-advanced-option yp-special-css-area yp-border-special-content'>
				".yp_get_radio_markup(
					'border-top-style',
					__('Style','yp'),
					array(
						'solid' => __('solid','yp'),
						'dotted' => __('dotted','yp'),
						'dashed' => __('dashed','yp'),
						'hidden' => __('hidden','yp')
					),
					'none',
					__('Sets the style of an elements top border.','yp')
				)."
				
				".yp_get_slider_markup(
					'border-top-width',
					__('Width','yp'),
					'',
					0,        // decimals
					'0,20',   // px value
					'0,100',  // percentage value
					'0,3',     // Em value
					__('Sets the width of an elements top border.','yp')
				)."
				
				".yp_get_color_markup(
					'border-top-color',
					__('Color','yp'),
					__('Sets the color of an elements top border.','yp')
				)."
				</div>
				
				<a class='yp-advanced-link yp-special-css-link yp-border-special'>".__('Border Right','yp')."</a>
				<div class='yp-advanced-option yp-special-css-area yp-border-special-content'>
				".yp_get_radio_markup(
					'border-right-style',
					__('Style','yp'),
					array(
						'solid' => __('solid','yp'),
						'dotted' => __('dotted','yp'),
						'dashed' => __('dashed','yp'),
						'hidden' => __('hidden','yp')
					),
					'none',
					__('Sets the style of an elements right border.','yp')
				)."
				
				".yp_get_slider_markup(
					'border-right-width',
					__('Width','yp'),
					'',
					0,        // decimals
					'0,20',   // px value
					'0,100',  // percentage value
					'0,3',     // Em value
					__('Sets the width of an elements right border.','yp')
				)."
				
				".yp_get_color_markup(
					'border-right-color',
					__('Color','yp'),
					__('Sets the color of an elements right border.','yp')
				)."
				</div>
				
				
				<a class='yp-advanced-link yp-special-css-link yp-border-special'>".__('Border Bottom','yp')."</a>
				<div class='yp-advanced-option yp-special-css-area yp-border-special-content'>
				".yp_get_radio_markup(
					'border-bottom-style',
					__('Style','yp'),
					array(
						'solid' => __('solid','yp'),
						'dotted' => __('dotted','yp'),
						'dashed' => __('dashed','yp'),
						'hidden' => __('hidden','yp')
					),
					'none',
					__('Sets the style of an elements bottom border.','yp')
				)."
				
				".yp_get_slider_markup(
					'border-bottom-width',
					__('Width','yp'),
					'',
					0,        // decimals
					'0,20',   // px value
					'0,100',  // percentage value
					'0,3',     // Em value
					__('Sets the width of an elements bottom border.','yp')
				)."
				
				".yp_get_color_markup(
					'border-bottom-color',
					__('Color','yp'),
					__('Sets the color of an elements bottom border.','yp')
				)."
				</div>
				
				
				<a class='yp-advanced-link yp-special-css-link yp-border-special yp-border-special-last'>".__('Border Left','yp')."</a>
				<div class='yp-advanced-option yp-special-css-area yp-border-special-content'>
				".yp_get_radio_markup(
					'border-left-style',
					__('Style','yp'),
					array(
						'solid' => __('solid','yp'),
						'dotted' => __('dotted','yp'),
						'dashed' => __('dashed','yp'),
						'hidden' => __('hidden','yp')
					),
					'none',
					__('Sets the style of an elements left border.','yp')
				)."
				
				".yp_get_slider_markup(
					'border-left-width',
					__('Width','yp'),
					'',
					0,        // decimals
					'0,20',   // px value
					'0,100',  // percentage value
					'0,3',     // Em value
					__('Sets the width of an elements left border.','yp')
				)."
				
				".yp_get_color_markup(
					'border-left-color',
					__('Color','yp'),
					__('Sets the color of an elements left border.','yp')
				)."
				</div>
				
			</div>
		</li>
		
		<li class='border-radius-option'>
			<h3>".__('Border Radius','yp')." ".yp_arrow_icon()."</h3>
			<div class='yp-this-content'>
				
				<div class='lock-btn'></div>
				".yp_get_slider_markup(
					'border-top-left-radius',
					__('Top Left Radius','yp'),
					'',
					0,        // decimals
					'0,50',   // px value
					'0,50',  // percentage value
					'0,6',     // Em value
					__('Defines the shape of the border of the top-left corner','yp')
				)."
				
				".yp_get_slider_markup(
					'border-top-right-radius',
					__('Top Right Radius','yp'),
					'',
					0,        // decimals
					'0,50',   // px value
					'0,50',  // percentage value
					'0,6',     // Em value
					__('Defines the shape of the border of the top-right corner','yp')
				)."
				
				".yp_get_slider_markup(
					'border-bottom-right-radius',
					__('Bottom Right Radius','yp'),
					'',
					0,        // decimals
					'0,50',   // px value
					'0,50',  // percentage value
					'0,6',     // Em value
					__('Defines the shape of the border of the bottom-right corner','yp')
				)."

				".yp_get_slider_markup(
					'border-bottom-left-radius',
					__('Bottom Left Radius','yp'),
					'',
					0,        // decimals
					'0,50',   // px value
					'0,50',  // percentage value
					'0,6',     // Em value
					__('Defines the shape of the border of the bottom-left corner','yp')
				)."
				
				
			</div>
		</li>
		
		<li class='position-option'>
			<h3>".__('Position','yp')." ".yp_arrow_icon()."</h3>
			<div class='yp-this-content'>

				".yp_get_slider_markup(
					'z-index',
					__('Z Index','yp'),
					'auto',
					0,        // decimals
					'-10,1000',   // px value
					'-10,1000',  // percentage value
					'-10,1000',     // Em value
					__('Specifies the stack order of an element. Z index only works on positioned elements (absolute, relative, or fixed).','yp')
				)."	
				
				".yp_get_radio_markup(
					'position',
					__('Position','yp'),
					array(
						'static' => 'static',
						'relative' => 'relative',
						'absolute' => 'absolute',
						'fixed' => 'fixed'
					),
					'',
					__('Specifies the type of positioning method used for an element','yp')
					
				)."
				
				".yp_get_slider_markup(
					'top',
					__('Top','yp'),
					'auto',
					0,        // decimals
					'-200,400',   // px value
					'0,100',  // percentage value
					'-12,12',     // Em value
					__('For absolutely: positioned elements, the top property sets the top edge of an element to a unit above/below the top edge of its containing element.<br><br>For relatively: positioned elements, the top property sets the top edge of an element to a unit above/below its normal position.','yp')
				)."

				".yp_get_slider_markup(
					'left',
					__('Left','yp'),
					'auto',
					0,        // decimals
					'-200,400',   // px value
					'0,100',  // percentage value
					'-12,12',     // Em value
					__('For absolutely: positioned elements, the left property sets the left edge of an element to a unit to the left/right of the left edge of its containing element.<br><br>For relatively: positioned elements, the left property sets the left edge of an element to a unit to the left/right to its normal position.','yp')
				)."

				".yp_get_slider_markup(
					'bottom',
					__('Bottom','yp'),
					'auto',
					0,        // decimals
					'-200,400',   // px value
					'0,100',  // percentage value
					'-12,12',     // Em value
					__('For absolutely: positioned elements, the bottom property sets the bottom edge of an element to a unit above/below the bottom edge of its containing element.<br><br>For relatively: positioned elements, the bottom property sets the bottom edge of an element to a unit above/below its normal position.','yp')
				)."
				
				".yp_get_slider_markup(
					'right',
					__('Right','yp'),
					'auto',
					0,        // decimals
					'-200,400',   // px value
					'0,100',  // percentage value
					'-12,12',     // Em value
					__('For absolutely: positioned elements, the right property sets the right edge of an element to a unit to the left/right of the right edge of its containing element.<br><br>For relatively: positioned elements, the right property sets the right edge of an element to a unit to the left/right to its normal position.','yp')
				)."
				
			</div>
		</li>
		
		<li class='size-option'>
			<h3>".__('Size','yp')." ".yp_arrow_icon()."</h3>
			<div class='yp-this-content'>

				".yp_get_slider_markup(
					'width',
					__('Width','yp'),
					'auto',
					0,        // decimals
					'0,500',   // px value
					'0,100',  // percentage value
					'0,52',     // Em value
					__('Sets the width of an element','yp')
				)."
				
				".yp_get_slider_markup(
					'height',
					__('Height','yp'),
					'auto',
					0,        // decimals
					'0,500',   // px value
					'0,100',  // percentage value
					'0,52',     // Em value
					__('sets the height of an element','yp')
				)."

				".yp_get_radio_markup(
					'box-sizing',
					__('Box Sizing','yp'),
					array(
						'border-box' => __('border-box','yp'),
						'content-box' => __('content-box','yp')
					),
					'content-box',
					__('is used to tell the browser what the sizing properties (width and height) should include. Should they include the border-box? Or just the content-box (which is the default value of the width and height properties)?','yp')
				)."
				
				".yp_get_slider_markup(
					'min-width',
					__('Min Width','yp'),
					'initial',
					0,        // decimals
					'0,500',   // px value
					'0,100',  // percentage value
					'0,52',     // Em value
					__('is used to set the minimum width of an element','yp')
				)."

				".yp_get_slider_markup(
					'min-height',
					__('Min Height','yp'),
					'initial',
					0,        // decimals
					'0,500',   // px value
					'0,100',  // percentage value
					'0,52',    // Em value
					__('is used to set the minimum height of an element','yp')
				)."
				
				".yp_get_slider_markup(
					'max-width',
					__('Max Width','yp'),
					'auto',
					0,        // decimals
					'0,500',   // px value
					'0,100',  // percentage value
					'0,52',     // Em value
					__('is used to set the maximum width of an element','yp')
				)."
				
				".yp_get_slider_markup(
					'max-height',
					__('Max Height','yp'),
					'auto',
					0,        // decimals
					'0,500',   // px value
					'0,100',  // percentage value
					'0,52',     // Em value
					__('is used to set the maximum height of an element','yp')
				)."
				
				
			</div>
		</li>

		<li class='animation-option'>
			<h3>".__('Animation','yp')." <span class='yp-badge yp-lite'>Pro</span> <span class='yp-badge yp-anim-recording'>".__('Recording','yp')."</span> ".yp_arrow_icon()."</h3>
			<div class='yp-this-content'>
				
				<p class='yp-alert-warning yp-top-alert yp-lite'>Animation ".__('property not available for lite version.','yp')." <a target='_blank' href='http://waspthemes.com/yellow-pencil/buy'>".__('Upgrade','yp')."?</a></p>
				
				<div class='animation-links-control yp-just-desktop'>

				<a class='yp-advanced-link yp-special-css-link yp-just-desktop yp-add-animation-link'>".__('Create Animation','yp')."</a>

				<a class='yp-advanced-link yp-special-css-link yp-just-desktop yp-animation-player'>".__('Play','yp')."</a>

				<a class='yp-advanced-link yp-special-css-link yp-just-desktop yp-animation-creator-start'>".__('Create','yp')."</a>

				<div class='yp-clearfix'></div>

				</div>

			";

				// Default animations
				$animations = array(
					'none' => 'none',
					'bounce' => 'bounce',
					'spin' => 'spin',
					'flash' => 'flash',
					'swing' => 'swing',
					'pulse' => 'pulse',
					'rubberBand' => 'rubberBand',
					'shake' => 'shake',
					'tada' => 'tada',
					'wobble' => 'wobble',
					'jello' => 'jello',
					'bounceIn' => 'bounceIn',
						
					'spaceInUp' => 'spaceInUp',
					'spaceInRight' => 'spaceInRight',
					'spaceInDown' => 'spaceInDown',
					'spaceInLeft' => 'spaceInLeft',
					'push' => 'push',
					'pop' => 'pop',
					'bob' => 'bob',
					'wobble-horizontal' => 'wobble-horizontal',
											
					'bounceInDown' => 'bounceInDown',
					'bounceInLeft' => 'bounceInLeft',
					'bounceInRight' => 'bounceInRight',
					'bounceInUp' => 'bounceInUp',
					'fadeIn' => 'fadeIn',
					'fadeInDown' => 'fadeInDown',
					'fadeInDownBig' => 'fadeInDownBig',
					'fadeInLeft' => 'fadeInLeft',
					'fadeInLeftBig' => 'fadeInLeftBig',
					'fadeInRight' => 'fadeInRight',
					'fadeInRightBig' => 'fadeInRightBig',
					'fadeInUp' => 'fadeInUp',
					'fadeInUpBig' => 'fadeInUpBig',
					'flipInX' => 'flipInX',
					'flipInY' => 'flipInY',
					'lightSpeedIn' => 'lightSpeedIn',
					'rotateIn' => 'rotateIn',
					'rotateInDownLeft' => 'rotateInDownLeft',
					'rotateInDownRight' => 'rotateInDownRight',
					'rotateInUpLeft' => 'rotateInUpLeft',
					'rotateInUpRight' => 'rotateInUpRight',
					'rollIn' => 'rollIn',
					'zoomIn' => 'zoomIn',
					'zoomInDown' => 'zoomInDown',
					'zoomInLeft' => 'zoomInLeft',
					'zoomInRight' => 'zoomInRight',
					'zoomInUp' => 'zoomInUp',
					'slideInDown' => 'slideInDown',
					'slideInLeft' => 'slideInLeft',
					'slideInRight' => 'slideInRight',
					'slideInUp' => 'slideInUp'
				);

				// Add dynamic animations.
				$all_options =  wp_load_alloptions();
				foreach($all_options as $name => $value){
					if(stristr($name, 'yp_anim')){
						$name = str_replace("yp_anim_", "", $name);
						$animations[$name] = ucwords(strtolower($name));
					}
				}
				
				echo " ".yp_get_select_markup(
					'animation-name',
					__('Animation','yp'),
					$animations,
					'none'
				)."
				
				".yp_get_select_markup(
					'animation-play',
					__('Animation Play','yp'),
					array(
						'yp_onscreen' => __('onScreen','yp'),
						'yp_hover' => __('Hover','yp'),
						'yp_click' => __('Click','yp'),
						'yp_focus' => __('Focus','yp')
					),
					'yp_onscreen',
					__('OnScreen: Playing animation when element visible on screen.<br><br>Hover: Playing animation when mouse on element.<br><br>Click: Playing animation when element clicked.<br><br>Focus: Playing element when click on an text field.','yp')
				)."
				
				".yp_get_select_markup(
					'animation-iteration-count',
					__('animation Iteration','yp'),
					array(
						'1' => '1',
						'2' => '2',
						'infinite' => __('infinite','yp')
					),
					'1'
				)."
				
				".yp_get_input_markup(
						'set-animation-name',
						__('Set Animation Name','yp'),
						'none'
					)."

				".yp_get_slider_markup(
					'animation-duration',
					__('Animation Duration','yp'),
					'0',
					2,        // decimals
					'1,10',   // px value
					'1,10',  // percentage value
					'1,10'     // Em/ms value
				)."

				".yp_get_slider_markup(
					'animation-delay',
					__('Animation Delay','yp'),
					'0',
					2,        // decimals
					'0,10',   // px value
					'0,10',  // percentage value
					'0,10'     // Em/ms value
				)."

				".yp_get_radio_markup(
					'animation-fill-mode',
					__('Animation Fill Mode','yp'),
					array(
						'forwards' => __('forwards','yp'),
						'backwards' => __('backwards','yp'),
						'both' => __('both','yp'),
					),
					'none',
					__('This property sets the state of the end animation when the animation is not running','yp')
				)."		
				
			</div>
		</li>
		
		<li class='filters-option'>
			<h3>".__('Filters','yp')." <span class='yp-badge yp-lite'>Pro</span>  ".yp_arrow_icon()."</h3>
			<div class='yp-this-content'>

				<p class='yp-alert-warning yp-top-alert yp-lite'>Filter ".__('property not available for lite version.','yp')." <a target='_blank' href='http://waspthemes.com/yellow-pencil/buy'>".__('Upgrade','yp')."?</a></p>

				".yp_get_slider_markup(
					'blur-filter',
					__('Blur','yp'),
					'0',
					2,        // decimals
					'0,10',   // px value
					'0,10',  // percentage value
					'0,10'     // Em value
				)."
				
				".yp_get_slider_markup(
					'brightness-filter',
					__('Brightness','yp'),
					'0',
					2,        // decimals
					'0,10',   // px value
					'0,10',  // percentage value
					'0,10'     // Em value
				)."
				
				".yp_get_slider_markup(
					'grayscale-filter',
					__('Grayscale','yp'),
					'0',
					2,        // decimals
					'0,1',   // px value
					'0,1',  // percentage value
					'0,1'     // Em value
				)."
				
				".yp_get_slider_markup(
					'contrast-filter',
					__('Contrast','yp'),
					'0',
					2,        // decimals
					'0,10',   // px value
					'0,10',  // percentage value
					'0,10'     // Em value
				)."
				
				".yp_get_slider_markup(
					'hue-rotate-filter',
					__('Hue Rotate','yp'),
					'0',
					0,        // decimals
					'0,360',   // px value
					'0,360',  // percentage value
					'0,360'     // Em value
				)."
				
				".yp_get_slider_markup(
					'saturate-filter',
					__('Saturate','yp'),
					'0',
					2,        // decimals
					'0,10',   // px value
					'0,10',  // percentage value
					'0,10'     // Em value
				)."
				
				".yp_get_slider_markup(
					'sepia-filter',
					__('Sepia','yp'),
					'0',
					2,        // decimals
					'0,1',   // px value
					'0,1',  // percentage value
					'0,1'     // Em value
				)."
			</div>
		</li>
		
		<li class='box-shadow-option'>
			<h3>".__('Box Shadow','yp')." ".yp_arrow_icon()."</h3>
			<div class='yp-this-content'>

				<p class='yp-alert-warning yp-top-alert yp-has-box-shadow'>".__('Set transparent color for hide box shadow property.','yp')."</p>

				".yp_get_color_markup(
					'box-shadow-color',
					__('Color','yp')
				)."
				
				".yp_get_slider_markup(
					'box-shadow-blur-radius',
					__('Blur Radius','yp'),
					'0',
					0,        	// decimals
					'0,50',   // px value
					'0,50',  // percentage value
					'0,50'     // Em value
				)."
				
				".yp_get_slider_markup(
					'box-shadow-spread',
					__('Spread','yp'),
					'0',
					0,        	// decimals
					'-50,100',   // px value
					'-50,100',  // percentage value
					'-50,100'     // Em value
				)."

				".yp_get_radio_markup(
					'box-shadow-inset',
					__('Inset','yp'),
					array(
						'no' => __('no','yp'),
						'inset' => __('inset','yp')
					),
					false
				)."		

				".yp_get_slider_markup(
					'box-shadow-horizontal',
					__('Horizontal Length','yp'),
					'0',
					0,        // decimals
					'-50,50',   // px value
					'-50,50',  // percentage value
					'-50,50'     // Em value
				)."
				
				".yp_get_slider_markup(
					'box-shadow-vertical',
					__('Vertical Length','yp'),
					'0',
					0,        	// decimals
					'-50,50',   // px value
					'-50,50',  // percentage value
					'-50,50'     // Em value
				)."

			</div>
		</li>
		
		<li class='extra-option'>
			<h3>".__('Extra','yp')." ".yp_arrow_icon()."</h3>
			<div class='yp-this-content'>

				<a class='yp-advanced-link yp-top yp-special-css-link yp-transform-link'>".__('Transform','yp')."</a>
				<div class='yp-advanced-option yp-special-css-area yp-transform-area'>
				".yp_get_slider_markup(
					'scale-transform',
					__('Scale','yp'),
					'0',
					2,        // decimals
					'0,5',   // px value
					'0,5',  // percentage value
					'0,5'     // Em value
				)."
				
				".yp_get_slider_markup(
					'rotate-transform',
					__('Rotate','yp'),
					'0',
					0,        // decimals
					'0,360',   // px value
					'0,360',  // percentage value
					'0,360'     // Em value
				)."

				".yp_get_slider_markup(
					'rotatex-transform',
					__('Rotate X','yp'),
					'0',
					0,        // decimals
					'0,360',   // px value
					'0,360',  // percentage value
					'0,360'     // Em value
				)."

				".yp_get_slider_markup(
					'rotatey-transform',
					__('Rotate Y','yp'),
					'0',
					0,        // decimals
					'0,360',   // px value
					'0,360',  // percentage value
					'0,360'     // Em value
				)."

				".yp_get_slider_markup(
					'rotatez-transform',
					__('Rotate Z','yp'),
					'0',
					0,        // decimals
					'0,360',   // px value
					'0,360',  // percentage value
					'0,360'     // Em value
				)."
				
				".yp_get_slider_markup(
					'translate-x-transform',
					__('Translate X','yp'),
					'0',
					0,        // decimals
					'-50,50',   // px value
					'-50,50',  // percentage value
					'-50,50'     // Em value
				)."
				
				".yp_get_slider_markup(
					'translate-y-transform',
					__('Translate Y','yp'),
					'0',
					0,        // decimals
					'-50,50',   // px value
					'-50,50',  // percentage value
					'-50,50'     // Em value
				)."
				
				".yp_get_slider_markup(
					'skew-x-transform',
					__('Skew X','yp'),
					'0',
					0,        // decimals
					'0,360',   // px value
					'0,360',  // percentage value
					'0,360'     // Em value
				)."
				
				".yp_get_slider_markup(
					'skew-y-transform',
					__('skew Y','yp'),
					'0',
					0,        // decimals
					'0,360',   // px value
					'0,360',  // percentage value
					'0,360'     // Em value
				)."

				".yp_get_slider_markup(
					'perspective',
					__('Perspective','yp'),
					'0',
					0,        // decimals
					'0,1000',   // px value
					'0,100',  // percentage value
					'0,62'     // Em value
				)."

				</div>
				
				
				".yp_get_slider_markup(
					'opacity',
					__('Opacity','yp'),
					'auto',
					2,        // decimals
					'0,1',   // px value
					'0,1',  // percentage value
					'0,1',     // Em value
					__('The opacity property can take a value from 0.0 - 1.0. The lower value, the more transparent.','yp')
				)."

				".yp_get_select_markup(
					'display',
					__('Display','yp'),
					array(
						'block' => __('block','yp'),
						'flex' => __('flex','yp'),
						'inline-block' => __('inline-block','yp'),
						'inline-flex' => __('inline-flex','yp'),
						'table-cell' => __('table-cell','yp'),
						'none' => __('none','yp'),
					),
					'inline',
					__('Specifies the type of box used for an element.','yp')
				)."
				
				".yp_get_radio_markup(
					'float',
					__('Float','yp'),
					array(
						'left' => __('left','yp'),
						'right' => __('right','yp')
					),
					'none',
					__('Specifies whether or not a box (an element) should float.','yp')
				)."

				".yp_get_radio_markup(
					'clear',
					__('Clear','yp'),
					array(
						'left' => __('left','yp'),
						'right' => __('right','yp'),
						'both' => __('both','yp')
					),
					'none',
					__('Specifies on which sides of an element where floating elements are not allowed to float.','yp')
				)."

				".yp_get_radio_markup(
					'visibility',
					__('Visibility','yp'),
					array(
						'visible' => __('visible','yp'),
						'hidden' => __('hidden','yp')
					),
					'inherit',
					__('specifies whether or not an element is visible.','yp')
				)."
				
				".yp_get_radio_markup(
					'overflow-x',
					__('Overflow X','yp'),
					array(
						'hidden' => __('hidden','yp'),
						'scroll' => __('scroll','yp'),
						'auto' => __('auto','yp')
					),
					'visible',
					__('specifies what to do with the left/right edges of the content - if it overflows the elements content area.','yp')
				)."
				
				".yp_get_radio_markup(
					'overflow-y',
					__('Overflow Y','yp'),
					array(
						'hidden' => __('hidden','yp'),
						'scroll' => __('scroll','yp'),
						'auto' => __('auto','yp')
					),
					'visible',
					__('specifies what to do with the left/right edges of the content - if it overflows the elements content area.','yp')
				)."
				
				
			</div>
		</li>
		
		<li class='yp-li-footer'>
			<h3><a target='_blank' href='http://waspthemes.com/yellow-pencil/documentation/'>".__('Documentation','yp')."</a> / V ".YP_VERSION."</h3>
		</li>
			
	</ul>";