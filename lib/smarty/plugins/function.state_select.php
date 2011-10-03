<?php
/**
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.state_select.php
 * Type:     function
 * Name:     state_select
 * Purpose:  returns a html select box populated with ISO Country Codes
 *           and Names. Also allows for specification of a custom default
 *           default selection.
 * Author:   jcornelius <www.jcornelius.com>
 * -------------------------------------------------------------
 */
function smarty_function_state_select($params, &$smarty)
{
   require_once $smarty->_get_plugin_filepath('function','html_options');

   $name = null;
   $selected = null;

   foreach($params as $_key => $_val)
   {
      switch($_key)
      {
         case 'name':
	    $$_key = (string)$_val;
	    break;
         case 'selected':
            $$_key = (string)$_val;
	    break;
      }
   }

   $state_codes = array(
                        "International" => array(
                        "**" => "Other Non CA / US"),
                        "United States" => array(
                        "AL" => "Alabama",
                        "AK" => "Alaska",
                        "AZ" => "Arizona",
                        "AR" => "Arkansas",
                        "CA" => "California",
                        "CO" => "Colorado",
                        "CT" => "Connecticut",
                        "DE" => "Delaware",
                        "DC" => "District of Columbia",
                        "FL" => "Florida",
                        "GA" => "Georgia",
                        "HI" => "Hawaii",
                        "ID" => "Idaho",
                        "IL" => "Illinois",
                        "IN" => "Indiana",
                        "IA" => "Iowa",
                        "KS" => "Kansas",
                        "KY" => "Kentucky",
                        "LA" => "Louisiana",
                        "ME" => "Maine",
                        "MD" => "Maryland",
                        "MA" => "Massachusetts",
                        "MI" => "Michigan",
                        "MN" => "Minnesota",
                        "MS" => "Mississippi",
                        "MO" => "Missouri",
                        "MT" => "Montana",
                        "NE" => "Nebraska",
                        "NV" => "Nevada",
                        "NH" => "New Hampshire",
                        "NJ" => "New Jersey",
                        "NM" => "New Mexico",
                        "NY" => "New York",
                        "NC" => "North Carolina",
                        "ND" => "North Dakota",
                        "OH" => "Ohio",
                        "OK" => "Oklahoma",
                        "OR" => "Oregon",
                        "PA" => "Pennsylvania",
                        "RI" => "Rhode Island",
                        "SC" => "South Carolina",
                        "SD" => "South Dakota",
                        "TN" => "Tennessee",
                        "TX" => "Texas",
                        "UT" => "Utah",
                        "VT" => "Vermont",
                        "VA" => "Virginia",
                        "WA" => "Washington",
                        "WV" => "West Virginia",
                        "WI" => "Wisconsin",
                        "WY" => "Wyoming"),

                        "US Territories" => array(
                        "AS" => "American Samoa",
                        "GU" => "Guam",
                        "MH" => "Marshall Islands",
                        "FM" => "Micronesia",
                        "MP" => "Northern Marianas",
                        "PW" => "Palau",
                        "VI" => "Virgin Islands",
                        "AA" => "Armed Forces(AA)",
                        "AE" => "Armed Forces(AE)",
                        "AP" => "Armed Forces(AP)"),

                        "Canada" => array(
                        "AB" => "Alberta",
                        "BC" => "British Columbia",
                        "MB" => "Manitoba",
                        "NB" => "New Brunswick",
                        "NL" => "Newfoundland",
                        "NT" => "Northwest Territory",
                        "NS" => "Nova Scotia",
                        "ON" => "Ontario",
                        "PE" => "Prince Edward Island",
                        "QC" => "Quebec",
                        "SK" => "Saskatchewan",
                        "YT" => "Yukon Territory")
                        );

   /**
    * if var $selected is not a country code set it to null and use
    * the specified text in the option group as the selected option
    */
/*
   if(!array_key_exists($selected,$state_codes))
   {
      $tmp = array($selected,"----------------");
      array_unshift($state_codes,$tmp[0],$tmp[1]);
      //$selected = "null";
   }
*/

   /**
    * if the name is not specified, default to 'country'
    */
/*
   if(empty($name))
   {
      $name = "state";
   }
*/

   $myArray = array( "name" => $name, "options" => $state_codes, "selected" => $selected );
   $HTML_Output = smarty_function_html_options($myArray, $smarty);

   return $HTML_Output;
}
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
?>
