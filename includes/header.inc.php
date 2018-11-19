<div id="header">
    	<div id="innerheader">
        	<div id="display_date">
            	<?php 
					$now = new DateTime();
					echo $now->format('l jS F, Y');
				?>	
            </div>
            
            <div id="display_time">
            </div>
            
            <div id="logo">
            	KAYZ JOURNAL
            </div>
            
            <div id="searchbar">
            	<input type="text" name="search" id="search" value="Search" onfocus="hideText()" onblur="showText()" />
            </div>
            
            <div id="quote_div">
            	<div id="innerquote_div" style="padding:5px;font-size:.9em;font-weight:normal;color:#ff9;">
                    
            	</div>
            </div>
        </div>
    </div>
