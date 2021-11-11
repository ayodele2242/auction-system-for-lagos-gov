<?php include('header.php'); ?>
<?php include('top-nav.php'); ?>
<?php /*ok what we're doing here is getting all the relevant fields to display for auctions, the description is intended to be accessed
	with jquery like the soupshack thing*/
	
	
	$query = "SELECT tcauctions.auctionid, tctrades.tradeid, auctionid, itemname, imgurl, expiretime, initprice, currentbid, buyout, 
    sellerid, buyerid FROM tcauctions JOIN tctrades ON tcauctions.auctionid = tctrades.tradeid AND tcauctions.expired = 0 "; 
	
	$result = mysqli_query($mysqli, $query);
	?> 
   
   <!--Main layout-->
  
        <div class="container-fluid mt-5 pt-5">
            <div class="block-header">
            <h2><span>Current Auction List</span></h2>         
            </div>




<div class="clearfix">
<div class="row">
    <div class="col-lg-2"></div>
    <div class="col-lg-8">
    <form action="TCbidauctionscript.php" method="post">
    <fieldset>
    
    <p>Select an auction and...</p>
    <label for="bidfield">Enter your bid:</label><input name="bidfield" type="text" id="bidfield"> 
    <input type="submit" name="bidsubmit" id="bidsubmit" value="Bid"> 
    <input type="submit" name="buyoutsubmit" id="buyoutsubmit" value="Buyout"><br>
    <br>
    <table class="table table-striped table_responsive" id="auctable">
    	<tr>
        	<th id="radbtn"></th>
        	<th id="imghead">Image</th>
            <th id="namehead">Item Name</th>
            <th id="expdate">Expire Date</th>
            <th id="usrnme">Seller</th>
            <th id="usrnme">Highest Bidder</th>
            <th id="numbox">Current Bid</th>
            <th id="numbox">Initial Price</th>
            <th id="numbox">Buyout</th>
        </tr>
    
    <?php
	while($row = mysqli_fetch_array($result)) {
		echo "<tr><td><input name=\"rad_auc_id\" type=\"radio\" value=\"{$row['auctionid']}\" id=\"radbtn\"></td><td id=\"imgbox\"><img height=\"50px\" width=\"50px\" src=\"images/{$row['imgurl']}\" id=\"{$row['auctionid']}\" alt=\"{$row['itemname']}\"></img></td> <td id=\"namehead\">" . $row['itemname'] . "</td><td id=\"expdate\">" . $row['expiretime'] . "</td><td id=\"usrnme\">" . $row['sellerid'] . "</td><td id=\"usrnme\"> "; //if buyer isnt null, post name, otherwise say something different
					if ($row['buyerid'] != NULL) {
						echo $row['buyerid'];
					} else { echo "None Yet."; }
					echo "</td>	<td id=\"numbox\">"; //if bid isnt null, echo bid, else none
					if ($row['currentbid'] != NULL) {
						echo "N" . $row['currentbid'];
					} else { echo "None Yet."; }
					echo "</td>	<td id=\"numbox\"> $" . $row['initprice'] . "</td><td id=\"numbox\"> "; //if buyout isnt null, list buyout, else none.
					if ($row['buyout'] != NULL) {
						echo "N" . $row['buyout'];
					} else { echo "None."; }
					echo "</td>	</tr>";
		
		
	}
	?>
    </table>
    <div id="popup"></div>
    </fieldset>
	</form>
</div>

</div>

      
        </div>


<?php include('footer.php'); ?>    

   