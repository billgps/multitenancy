<?php

/*
 * PHP QR Code encoder
 *
 * Common constants
 *
 * Based on libqrencode C library distributed under LGPL 2.1
 * Copyright (C) 2006, 2007, 2008, 2009 Kentaro Fukuchi <fukuchi@megaui.net>
 *
 * PHP QR Code is distributed under LGPL 3
 * Copyright (C) 2010 Dominik Dzienia <deltalab at poczta dot fm>
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 3 of the License, or any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 */
 
	// Encoding modes
	 
	// if (!defined('QR_MODE_NUL')) define('QR_MODE_NUL', -1);
	// if (!defined('QR_MODE_NUM'))define('QR_MODE_NUM', 0);
	// if (!defined('QR_MODE_AN'))define('QR_MODE_AN', 1);
	// if (!defined('QR_MODE_8'))define('QR_MODE_8', 2);
	// if (!defined('QR_MODE_KANJI'))define('QR_MODE_KANJI', 3);
	// if (!defined('QR_MODE_STRUCTURE'))define('QR_MODE_STRUCTURE', 4);

	// // // Levels of error correction.

	// if (!defined('QR_ECLEVEL_L')) define('QR_ECLEVEL_L', 0);
	// if (!defined('QR_ECLEVEL_M'))define('QR_ECLEVEL_M', 1);
	// if (!defined('QR_ECLEVEL_Q'))define('QR_ECLEVEL_Q', 2);
	// if (!defined('QR_ECLEVEL_H'))define('QR_ECLEVEL_H', 3);
	
	// // Supported output formats
	
	// if (!defined('QR_FORMAT_TEXT'))define('QR_FORMAT_TEXT', 0);
	// if (!defined('QR_FORMAT_PNG'))define('QR_FORMAT_PNG',  1);
	
	class qrstr {
		public static function set(&$srctab, $x, $y, $repl, $replLen = false) {
			$srctab[$y] = substr_replace($srctab[$y], ($replLen !== false)?substr($repl,0,$replLen):$repl, $x, ($replLen !== false)?$replLen:strlen($repl));
		}
	}	