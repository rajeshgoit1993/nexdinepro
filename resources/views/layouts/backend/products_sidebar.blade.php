
  <li class="nav-item ">
            <a href="{{URL::route('all_products')}}" class="nav-link {{ Request::is('All-Products-List') || Request::is('Add-Product-List')

? 'active' :'' }} @if(Request::segment(1)=='Product-Edit') active @endif">
             <i class="nav-icon fas fa-braille"></i>   
              <p>
                Food Ingredients
               
              </p>
            </a>
          </li> 


