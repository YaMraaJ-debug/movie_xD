@extends('site_app')

@section('head_title', $page_info->page_title.' | '.getcong('site_name') )

@section('head_url', Request::url())

@section('content')
  
  
<!-- Start Breadcrumb -->
<div class="breadcrumb-section bg-xs" style="background-image: url({{ URL::asset('site_assets/images/breadcrum-bg.jpg') }})">
    <div class="container-fluid">
      <div class="row">
        <div class="col-xl-12"> 
          <h2>{{stripslashes($page_info->page_title)}}</h2>
          <nav id="breadcrumbs">
            <ul>
              <li><a href="{{ URL::to('/') }}" title="{{trans('words.home')}}">{{trans('words.home')}}</a></li>
              <li>{{stripslashes($page_info->page_title)}}</li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </div>
<!-- End Breadcrumb --> 

<!-- Banner -->
@if(get_web_banner('other_page_top')!="")      
      <div class="vid-item-ptb banner_ads_item pb-1" style="padding: 15px 0;">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
             {!!stripslashes(get_web_banner('other_page_top'))!!}
          </div>
        </div>  
        </div>
      </div>
  @endif

<!-- Start Details Info Page -->
<div class="details-page-area vfx-item-ptb vfx-item-info">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="details-item-block">
          
            {!!stripslashes($page_info->page_content)!!}

        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Details Info Page -->  

<!-- Banner -->
@if(get_web_banner('other_page_bottom')!="")      
      <div class="vid-item-ptb banner_ads_item pb-1" style="padding: 15px 0;">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
             {!!stripslashes(get_web_banner('other_page_bottom'))!!}
          </div>
        </div>  
        </div>
      </div>
  @endif
 
@endsection