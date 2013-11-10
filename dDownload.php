<?php
	
	$wc = simplexml_load_file("WebConfig.xml");
	$filepath = $_SERVER["DOCUMENT_ROOT"] . $wc->Site . $_REQUEST["Arquivo"];
	if (file_exists($filepath))
	{
		$filename = basename($filepath);
		header("Content-type: " . ReturnExtension($filepath));
		header("Content-Disposition: attachment; filename=\"".$filename."\"");
		header("Content-Length: ".filesize($filepath));

		$fp = readfile($filepath, "r");
		return $fp; 
	}
		
	function ReturnExtension($filepath)
	{
		$path_info = pathinfo($filepath);
	    switch ($path_info['extension'])
        {
			case ".htm":
			case ".html":
			case ".php":
			case ".aspx":
				return "text/HTML";
			case ".cs":
			case ".sql":
			case ".txt":
			case ".log":
				return "text/plain";
			case ".doc":
				return "application/ms-word";
			case ".tiff":
			case ".tif":
				return "image/tiff";
			case ".asf":
				return "video/x-ms-asf";
			case ".avi":
				return "video/avi";
			case ".zip":
				return "application/zip";
			case ".xls":
			case ".csv":
				return "application/vnd.ms-excel";
			case ".gif":
				return "image/gif";
			case ".jpg":
			case "jpeg":
				return "image/jpeg";
			case ".bmp":
				return "image/bmp";
			case ".wav":
				return "audio/wav";
			case ".mp3":
				return "audio/mpeg3";
			case ".mpg":
			case "mpeg":
				return "video/mpeg";
			case ".rtf":
				return "application/rtf";
			case ".asp":
				return "text/asp";
			case ".pdf":
				return "application/pdf";
			case ".fdf":
				return "application/vnd.fdf";
			case ".ppt":
				return "application/mspowerpoint";
			case ".dwg":
				return "image/vnd.dwg";
			case ".msg":
				return "application/msoutlook";
			case ".xml":
			case ".sdxl":
				return "application/xml";
			case ".xdp":
				return "application/vnd.adobe.xdp+xml";
			default:
				return "application/octet-stream";
		}
	}
?>