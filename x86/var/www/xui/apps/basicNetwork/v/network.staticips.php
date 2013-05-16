<form id='fe'>
<div class='pageTitle'>Network: Lan</div>
<div class='controlBox'>
<pre>
WINS?
</pre>
<br>

<table><tbody>
<tr><td>Lan IP</td><td><input id='lanip' name='lanip' /></td></tr>
<tr><td>Mask</td><td><input id='lanmask' name='lanmaskValue' /></td></tr>
</tbody></table>

<table><tbody>
<tr><td>DHCP Server</td><td>
 <input type="checkbox" id="dhcpToggle" name='dhcpToggle' class="slideToggle" />
 <label class="slideToggleViewport" for="dhcpToggle">
 <div class="slideToggleSlider">
   <div class="slideToggleButton slideToggleButtonBackground">&nbsp;</div>
   <div class="slideToggleContent slideToggleLeft button buttonSelected"><span>On</span></div>
   <div class="slideToggleContent slideToggleRight button"><span>Off</span></div>
  </div>
 </label>
</td></tr>
<tr><td>Lease</td><td><input id='dhcpLease' name='dhcpLease' /></td></tr>

<tr><td>DHCP Range</td><td>
 <input id='dhcpLower' name='dhcpLower' /> - <input id='dhcpUpper' name='dhcpUpper' />
 <div id='dhcpSlider' class='rangeSlider'></div>
</td></tr>


</tbody></table>

<table><tbody>

<tr><td></td><td>
</td></tr>

<tr><td></td><td>
</td></tr>

</tbody></table>

<input type='button' value='test' onclick='sub();'>

</div>

<div class='controlBox'>
<pre id='demov'></pre>
<pre id='demo'></pre>

</form>
</div>

<script type='text/ecmascript'>


 var network = {
//  ipMin: 
 }

 var lan = {
  ip: '10.0.0.1',
  mask: '255.255.255.0'
 }

 var dhcp = {
  lower: '10.0.0.100',
  upper: '10.0.0.199'
 }

 var dhcpRangeMin = ip2long('10.0.0.1');
 var dhcpRangeMax = ip2long('10.0.0.254');

function spinnerConstraint(spinner){
  var curv = $(spinner).ipspinner('value');
  if( curv < $(spinner).ipspinner('option','min') ) $(spinner).ipspinner('value', $(spinner).ipspinner('option','min') );
  else if( curv > $(spinner).ipspinner('option','max') ) $(spinner).ipspinner('value', $(spinner).ipspinner('option','max') );
}

$('#lanip').ipspinner({
 min: '10.0.0.1', max: '10.255.255.254',
 page: Math.pow(2,(32-mask2cidr(lan.mask))),
 change: function(event,ui){ spinnerConstraint(this);
//  var curv = $(this).ipspinner('value');
//  if( curv < $(this).ipspinner('option','min') ) $(this).ipspinner('value', $(this).ipspinner('option','min') );
//  else if( curv > $(this).ipspinner('option','max') ) $(this).ipspinner('value', $(this).ipspinner('option','max') );
 }
}).ipspinner('value',lan.ip);

$( '#lanmask' ).maskspinner({
 spin: function(event,ui){ $('#lanip').ipspinner('option','page', Math.pow(2,(32-ui.value)) ) }
}).maskspinner('value',lan.mask);

/* Slider with Spinners BEGIN */

 $('#dhcpLower').ipspinner({
  min: dhcpRangeMin, max: dhcp.upper,
  spin: function(event, ui){
   $('#dhcpSlider').slider('values', '0', ui.value);
   $('#dhcpUpper').ipspinner('option','min', ui.value );
  },
  change: function(event,ui){ spinnerConstraint(this);
//   var curv = $(this).ipspinner('value');
//   if( curv < $(this).ipspinner('option','min') ) $(this).ipspinner('value', $(this).ipspinner('option','min') );
//   else if( curv > $(this).ipspinner('option','max') ) $(this).ipspinner('value', $(this).ipspinner('option','max') );
   var curv = $(this).ipspinner('value');
   $('#dhcpSlider').slider('values', '0', curv );
   $('#dhcpUpper').ipspinner('option','min', curv );
  }
 })

 $('#dhcpUpper').ipspinner({
  min: dhcp.lower, max: dhcpRangeMax,
  spin: function(event, ui){
   $('#dhcpSlider').slider('values', '1', ui.value);
   $('#dhcpLower').ipspinner('option','max', ui.value );
  },
  change: function(event,ui){ spinnerConstraint(this);
//   var curv = $(this).ipspinner('value');
//   if( curv < $(this).ipspinner('option','min') ) $(this).ipspinner('value', $(this).ipspinner('option','min') );
//   else if( curv > $(this).ipspinner('option','max') ) $(this).ipspinner('value', $(this).ipspinner('option','max') );
   var curv = $(this).ipspinner('value');
   $('#dhcpSlider').slider('values', '1', curv );
   $('#dhcpLower').ipspinner('option','max', curv );
  }
 })

 $('#dhcpSlider').slider({
  range: true,
  min: dhcpRangeMin,
  max: dhcpRangeMax,
  values: [ip2long(dhcp.lower),ip2long(dhcp.upper)],
  slide: function(event, ui){
   $('#dhcpLower').ipspinner('value',ui.values[0]);
   $('#dhcpUpper').ipspinner('value',ui.values[1]);
   $('#dhcpLower').ipspinner('option','max', ui.values[1] );
   $('#dhcpUpper').ipspinner('option','min', ui.values[0] );
  }
 });

/* Slider with Spinners END */

$(function(){

$('#dhcpLease').spinner({ min: 0, max: 525600 });

$('#dhcpLower').ipspinner('value', dhcp.lower );
$('#dhcpUpper').ipspinner('value', dhcp.upper );

$('#dhcpLease').spinner('value',86400);

});

</script>