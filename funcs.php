<?php

function uchr ($u) {
	return mb_convert_encoding(pack("N",$u), mb_internal_encoding(), 'UCS-4BE');
}

?>