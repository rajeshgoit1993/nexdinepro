<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
   
    <title>LOI</title>
  
      <style>
            /** 
            * Define the width, height, margins and position of the watermark.
            **/
            #watermark {
                position: fixed;

                /** 
                    Set a position in the page for your image
                    This should center it vertically
                **/
                bottom:   10cm;
                left:     3.5cm;

                /** Change image dimensions**/
                width:    10cm;
                height:   10cm;

                /** Your watermark should be behind every content**/
                z-index:  -1000;
                opacity: .2;

            }
        </style>
  </head>
  <body>
    <div id="watermark">
            <img src="{{url('resources/assets/logo/water.png')}}" height="100%" width="100%" />
        </div>
         <main> 
                   
    <h4 class="center"> Letter of Intent </h4>
    <p>Date: <?php echo date("d-m-Y",strtotime($fanchise_detail->created_at)); 
         ?></p>
    <p>To:</p>
    <p>{{$fanchise_detail->name}},</p>

    <p>On behalf of Skyland Group termed as <b>{{CustomHelpers::get_brand_name($data->brands)}}</b> .  We are pleased to present this binding Letter of Intent (“Agreement”) on the following terms and conditions: </p>
    <h4>Franchisee</h4>
<p><b>{{$fanchise_detail->name}}, {{$fanchise_detail->address}},{{$fanchise_detail->state}},{{$fanchise_detail->dist}},{{$fanchise_detail->city }} - </b></p>
(if not already in place shall be formed by Franchisee within 15-days of the acceptance of this Agreement). 
<p>No. of Outlets-01 One Only</p>
Territory - {{$fanchise_detail->city}} -{{$fanchise_detail->state}} <br>


Franchise Fee  – Rs {{$data->booking_amount}}/-+Gst <br>
Token Amount  – Rs. {{$data->advance_received}}/-+Gst to be paid for booking franchise fee 
<br>
<p>Term: {{CustomHelpers::get_master_table_data('brands','id',$data->brands,'terms')}} </p>
<h4>Skyland Group</h4>
<p>Brand Owner grants to the Franchisee the exclusive right to open and operate the above mentioned brands in the specified location/Territory. </p>
<h4>Skyland Group System and Modifications </h4>
<p><b>Skyland Group </b>contains, among other things, specific and proprietary methods, standards, processes, products, services, and other information (“System”).  </p>

<p>The Franchisee shall be required to follow the System and the branding requirements of  <b>Skyland Group</b></p>
<p>The Franchisee will be permitted to modify the system and incorporate methods, products and processes as reasonably required by cultural, local customs or traditions, provided that prior written consent is obtained from the Brand Owner by the Franchisee. The Franchisee must be able to demonstrate to the Brand Owner the justification and need for the reasonable modifications based on a written business plan setting out sufficient data and the required modifications, parties acting reasonably. </p>
<h4>Products, Equipment & Shipping </h4>
Brand Owner will permit the Franchisee to purchase from the Franchisee’s own suppliers, such products, equipment, uniforms or other items required for the operation as per standards of the brand</b>. 

<h4>Initial Fee and Payment </h4>
<p>The Franchise fee amount payment terms will be wired in the following format as Payment (“Payment”) upon execution of this Letter Of Intent dtd <?php echo date("d-m-Y",strtotime($fanchise_detail->created_at)); 
         ?> ;</p>



<table>


<tr>
<td><b>*1st  installment </b></td>
<td>{{$data->first_installment}} /-+GST </td>
<td><b>Due Payment schedule in </b></td>
<td>{{$data->first_installment_date}}</td>
</tr>


@if($data->seoond_installment!='')
<tr>
<td><b>*2nd  installment </b></td>
<td>{{$data->seoond_installment}} /-+GST </td>
<td><b>Due Payment schedule in </b></td>
<td>{{$data->second_installment_date}}</td>

</tr>
@endif
@if($data->third_installment!='')
<tr>
<td><b>*3rd  installment </b></td>
<td>{{$data->third_installment}} /-+GST</td>
<td><b>Due before Outlet Launch</b></td>
<td>{{$data->third_installment_date}}</td>

</tr>
@endif
</table>


<p>Save and except as set out below, the payment received are non-refundable. </p>
<h4>Continuing Fees</h4> 
<p>Restaurants owned or operated by Franchisees</p>
<p><b>
    
@if($data->royality==2)
   {{$data->royality_amount}}% 
@else
{{$data->royality_amount}}
    @endif

Revenue Share</b> of the Gross revenue shall be remitted monthly by bank wire to the Brand Owner. The same is to be remitted by <b>10th</b> of each calendar month via PDC’s/ E-Nach Auto-Debit. 
</p>
 <p>PDC’s shall be submitted for the agreement tenure as a security.</p>
<h4>Currency</h4>
<p>All currency as used in this Agreement is INR otherwise indicated.</p>

<h4>Conditions of this Agreement </h4>
<p>This Agreement is conditional upon the following:</p> 
<h5>Approval of Franchisee:</h5>

<p>This Agreement and the Brand Owner Agreement is conditional as follows: </p>


<p>1. The Brand Owner will have sole and unfettered discretion to approve or not approve the Franchisee. This assessment shall be completed within 15 days of receiving a fully signed Letter of Intent and the applicable Payment. In the event that the Brand Owner does not approve the Franchisee, the Brand Owner shall retain the Payment, plus reasonable costs incurred by the Brand Owner, including without limitation legal and other costs in preparing this Agreement, costs of meetings and travel costs.</p> 
<h5>Financial Status </h5>
<p>The Franchisee confirms it has or shall obtain sufficient financing or financial resources so that it can be the Franchise for the Territory. </p>
<h5>Obligations of Brand Owner </h5>
<ul>

<ol>The obligations of the Brand Owner to the Franchisee shall be as follows:  </ol>
<ol>1. Location Assessment - Coordinate by email and telephone to provide guidance and assistance regarding the assessment of the Franchisee’s locations </ol>
<ol>2. Build-out/Construction/Design/Manual - Coordinate by email and telephone to provide guidance and assistance regarding the construction, build-out and design matters of the 
The Brand Owner shall provide a Franchisee with Construction Guidelines which sets out the design/specification criteria (which shall be subject to local laws, by-laws, codes, etc.). The Franchisee may be permitted to alter the design criteria provided it has the prior written agreement of the Brand Owner, parties acting reasonably, and provided that there is a sound design and branding basis as clearly demonstrated by the Franchisee. 
 </ol>
<ol>3.   Equipment Package - All equipment provided by <b>Skyland Group </b> or purchased by an authorized supplier subject to <b>Skyland Group</b> Approval.</ol>
<ol>4.   Leasing - Coordinate with the Franchisee counsel as reasonably necessary by email and telephone to provide guidance and assistance with respect to the terms of the leasing Letter of Intent and leasing particulars relevant to <b>{{CustomHelpers::get_brand_name($data->brands)}}</b> or the Franchisee’s location, subject to Franchisee’s required local attorney advice.  </ol>
<ol>5.   Suppliers - Coordinate by email and telephone to provide guidance in setting up food/beverage and equipment supplier accounts during the first year of Term.  
</ol>
<ol>6.   Initial Franchisee Training - Provide the Franchisee one-time franchisee training for kitchen staff. The training shall be held in Corporate office (Brand Owner) or outlet (Franchisee’s) location, to be determined by the Brand Owner on a date that is mutually convenient to all parties prior to the opening of the first location. The cost of training instruction and materials shall be borne by the Brand Owner. All other expenses incurred by the Franchisee before and during the training including, without limitation, costs of flights and accommodations, shall be borne by the Franchisee. </ol>
<ol>7.   Operations Manual - Provide the Franchisee with an Operations Manual which sets out the design/specification criteria for India (which shall be subject to local laws, by-laws, codes, etc.). </ol>
<ol>8.   Marketing Materials - Provide the Franchisee with the marketing materials and initiatives it may develop or obtain from Skyland Group (which it obtains and is legally permitted to share). </ol>
<ol>9.   Initial Launch – On Site Location Opening guidance will be provided by Brand Owner and all guidelines will be given to assist the franchisee. </ol>
<ol>10.  Ongoing assistance - Monthly KPI review system will be followed by phone/ Skype, during which all matters concerning the franchisee will be discussed. Also add that there will be a prescribed set of reports (defined separately in annexure) that will be expected from Franchisee to ensure that these review sessions maximize the benefit to the franchisee</ol>
<ol>11.  Documentation - All materials and documents provided by Brand Owner, including the Franchise Agreement, shall be in the English language. Any translations must be completed at the expense of Franchisee</ol>

</ul>
{!! CustomHelpers::get_master_table_data('brands','id',$data->brands,'extra_policy') !!}

<h5>Obligations of Franchisee  </h5>
<p>In addition to the obligations listed in other sections of this Agreement, the obligations of the Franchisee to the Brand Owner shall be as follows:  </p>
<ul>

<ol>1.   Skyland Group System - The Franchisee shall ensure that all Franchise brands and restaurants of Skyland Group shall operate in accordance to the Operations Manual and the requirements as set out in the Franchise Agreement and as per the brand of Skyland Group</ol>
<ol>2.   Operations/Evaluations - The Franchisee shall follow the reasonable policies and procedures as changed from time to time regarding the evaluations of the restaurant locations to ensure the minimum thresholds of standards of cleanliness, health, customer service, food and beverage quality, uniformity of appearance and image. Franchisee acknowledges and understands that it is the Franchisee’s responsibility to perform these restaurant evaluations. </ol>
<ol>3.   Sales/Reports/POS - The Franchisee shall be required to use a POS system as designated by the Brand Owner in all restaurant locations and Franchisee’s head office. The Franchisee’s Head Office POS system shall  automatically send information regarding daily, weekly or monthly sales reports to the Brand Owner in a format and method as determined by the Brand Owner.
</ol>

<ol>4.  Franchisee shall automatically wire the monthly royalty to the bank account designated by the Brand Owner.</ol>
<ol>5.   The Brand Owner reserves the right to amend the reporting and payment methods from time to time, acting reasonably. </ol>
<ol>6.   Marketing/Advertising - The Franchisee shall provide the Brand Owner with copies of all implemented marketing and branding plans and programs and promptly report to the Brand Owner as to the general level of success of such plans and programs. </ol>
<ol>7.   Documents - The Franchisee shall provide to the Brand Owner copies of all contracts and documentation relating to the operation of the Franchise.</ol>
<ol>8.   Franchisee must provide CCTV camera access to Brand Owner in order to monitor and audit system and process adherence at the outlet.</ol>
<ol>9. GST and FSSAI License is mandatory requisite before the launch of the outlet.</ol>
</ul>

<h5>Franchise Agreement </h5>
<p>The Brand Owner shall provide the Franchisee with a Franchise Agreement within 30 days of the full execution of this Agreement and receipt of the Deposit. The Franchise Agreement shall incorporate the provisions contained in this Agreement together with such reasonable amendments as are agreed upon by the parties. The Franchise Agreement shall also contain other provisions including but not limited to the reasonable obligations of Brand Owner and Franchisee and reasonable Brand Owner remedies for defaults.  </p>
<p>The parties shall act reasonably and diligently to finalize the terms of the Franchise Agreement within 45 days of the full execution of this Agreement or opening of outlet, whichever is earlier and receipt of the Deposit. In the event the parties are unable to enter into a Franchise Agreement within 45 days, the Brand Owner shall be entitled to terminate this Agreement and retain the Deposit. </p>

<h5>Confidential Information </h5>
<p>The Franchisee agrees to keep the terms of this Agreement and the Franchise Agreement and keep all information and documents it has received or shall receive from the other, or its agents, strictly confidential and shall not disclose the terms or information to any other party, other than its agents and professionals who are obligated to keep the information or documents in confidence. </p>

<h5>Governing Law, Jurisdiction and Venue </h5>
<p>This Agreement and any subsequent agreements will be interpreted and construed under the laws of India. All legal proceedings will only be commenced by the parties in New Delhi, India unless a party can only commence a proceeding in another jurisdiction in order to enforce this Agreement or obtain the appropriate remedy. The parties irrevocably submit to the jurisdiction of the competent courts of New Delhi, India over any suit, action or proceeding brought by either party to enforce this Agreement. </p>


<h5>Lawful Provisions </h5>
<p>If any term, covenant or condition of this Agreement shall to any extent be invalid or unenforceable, the remainder of this Agreement or application of such term, covenant or condition to persons or circumstances other than those as to which it is held invalid or unenforceable, shall not be affected thereby and each term, covenant or condition of this Agreement will be valid and enforced to the fullest extent permitted by law.  
</p> 
<h5>Entire Agreement</h5>
<p>This Agreement constitutes the entire agreement between the parties and supersedes all previous agreements and understandings between the parties in any way relating to the subject matter hereof, and there have been no other representations or warranties made by the Brand Owner, other than as set out in this Agreement, nor has there been any reliance by the Franchisee on any representations or warranties not explicitly provided in this Agreement. </p>
<p>The Franchisee also acknowledges and agrees that no employee, agent or representative of the Brand Owner or its affiliates made any oral, written or visual representation or projection to the Franchisee of actual or potential sales, earnings, or net or gross profits.  
 </p>
 <h5>Counterparts and Electronic Signature </h5>
<p>This Agreement may be executed in counterparts and by electronic signature and may be delivered via facsimile, email or other electronic means and each part will be deemed to be an original and all of which will constitute one and the same document. 
 </p>
 <h5>Non-Liability of Parent Company, Affiliates, etc. </h5>
<p>Skyland Group, is or will be the parent company (“Parent Company”) of the Brand Owner.  </p>
<p>The Franchisee acknowledges, understands and agrees that the Parent Company, its successors, parent, affiliates (other than the Brand Owner entity for your country), principals, agents or employees, will in no way be liable for any of the obligations or matters arising from or related to this Agreement or the Franchise Agreement. Any claim or right of action or any proceeding whatsoever of the Franchisee may be brought against the Brand Owner brand only, and not the Parent Company or the principals, agents or employees of the Parent Company or the Brand Owner. Franchisee and its principals, agents, or employees will not make any claim against the Parent Company or its successors, or affiliates, principals, agents, or employees that arises from or is related to this Agreement or the Franchise Agreement. </p>


<p>Sincerely,</p>
<p>On behalf of Skyland Group</p>

<p><strong>Chitra Sharma</strong></p>
<p>Business Head</p>



<p>AGREED TO: </p>
<p>On behalf of Franchisee</p>
<p>{{$fanchise_detail->name}}, </p>




                      
<p>The signed copy of this Letter of Intent has to be received by Brand Owner from Franchisee within 3 days of issue of this document from Brand Owner, if not the document shall be considered accepted.  </p> 





 </main>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>