<?php
/**
 * Created by PhpStorm.
 * User: mrksohag
 * Date: 10/30/17
 * Time: 12:28 PM
 */
?>
@extends('nptl-admin/Auth/AuthLayout')
@section('title','Register')

@section('reff_page_link')
    <span id="extr-page-header-space"> <span class="hidden-mobile">Already registered?</span> <a href="{{url(config('constant.smAdminSlug').'/login')}}" class="btn btn-danger">Sign In</a> </span>

@endsection

@section('content')
    <div class="well no-padding">
        <form class="smart-form client-form" id="smart-form-register"  role="form" method="POST" action="{{ url(config('constant.smAdminSlug').'/register') }}">
            {!! csrf_field() !!}

            <header>
                Registration is FREE*
            </header>

            <fieldset>
                @if(Session::has('message'))
                    <div class="warning">
                        {{ Session::get('message')}}
                    </div>
                @endif
                @if(Session::has('s_message'))
                    <div class="success">
                        {{ Session::get('s_message')}}
                    </div>
                @endif

                <section>
                    <label class="input{{ $errors->has('username') ? ' state-error' : '' }}">
                        <i class="icon-append fa fa-user"></i>
                        <input type="text" class="{{ $errors->has('username') ? 'invalid' : '' }}" name="username" placeholder="Username" value="{{ old('username') }}">
                        <b class="tooltip tooltip-bottom-right">Enter your username</b> </label>
                    @if ($errors->has('username'))
                        <em class="invalid" for="username">{{ $errors->first('username') }}</em>
                    @endif
                </section>

                <section>
                    <label class="input{{ $errors->has('email') ? ' state-error' : '' }}">
                        <i class="icon-append fa fa-envelope"></i>
                        <input type="email" name="email" class="{{ $errors->has('email') ? ' invalid' : '' }}" placeholder="Email address" value="{{ old('email') }}">
                        <b class="tooltip tooltip-bottom-right">Enter your email</b> </label>
                    @if ($errors->has('email'))
                        <em class="invalid" for="email">{{ $errors->first('email') }}</em>
                    @endif
                </section>

                <section>
                    <label class="input{{ $errors->has('password') ? ' state-error' : '' }}">
                        <i class="icon-append fa fa-lock"></i>
                        <input type="password" name="password" class="{{ $errors->has('password') ? ' invalid' : '' }}" placeholder="Password" id="password" value="{{ old('password') }}">
                        <b class="tooltip tooltip-bottom-right">Enter your password (Min 6 character's)</b> </label>
                    @if ($errors->has('password'))
                        <em class="invalid" for="password">{{ $errors->first('password') }}</em>
                    @endif
                </section>

                <section>
                    <label class="input"> <i class="icon-append fa fa-lock"></i>
                        <input type="password" name="password_confirmation" placeholder="Confirm password" value="{{ old('password_confirmation') }}">
                        <b class="tooltip tooltip-bottom-right">Enter your confirm password</b> </label>
                </section>
            </fieldset>

            <fieldset>
                <div class="row">
                    <section class="col col-6">
                        <label class="input{{ $errors->has('firstname') ? ' state-error' : '' }}">
                            <input type="text" class="{{ $errors->has('firstname') ? ' invalid' : '' }}" name="firstname" placeholder="First name" value="{{ old('firstname') }}">
                        </label>
                        @if ($errors->has('firstname'))
                            <em class="invalid" for="firstname">{{ $errors->first('firstname') }}</em>
                        @endif
                    </section>
                    <section class="col col-6">
                        <label class="input{{ $errors->has('lastname') ? ' state-error' : '' }}">
                            <input type="text" class="{{ $errors->has('lastname') ? ' invalid' : '' }}" name="lastname" placeholder="Last name" value="{{ old('lastname') }}">
                        </label>
                        @if ($errors->has('lastname'))
                            <em class="invalid" for="lastname">{{ $errors->first('lastname') }}</em>
                        @endif
                    </section>
                </div>

                <div class="row">
                    <section class="col col-6" >
                        <label class="select{{ $errors->has('gender') ? ' state-error' : '' }}" >
                            <select name="gender" class="{{ $errors->has('gender') ? ' invalid' : '' }}" >
                                <option value="0" selected="" disabled="">Gender</option>
                                <option value="1" {{ old('gender')==1? 'selected':'' }}>Male</option>
                                <option value="2" {{ old('gender')==2? 'selected':'' }}>Female</option>
                            </select> <i></i> </label>
                        @if ($errors->has('gender'))
                            <em class="invalid" for="email">{{ $errors->first('gender') }}</em>
                        @endif
                    </section>
                    <section class="col col-6">
                        <label class="input"> <i class="icon-append fa fa-calendar"></i>
                            <input type="text" name="request" placeholder="Request activation on" class="datepicker" data-dateformat='dd/mm/yy'  value="{{ old('request') }}">
                        </label>
                    </section>
                </div>

                <section>
                    <label class="checkbox">
                        <input type="checkbox" name="subscription" value="1" id="subscription" {{ old('subscription')==1? 'checked':'' }}>
                        <i></i>I want to receive news and special offers</label>
                    <label class="checkbox{{ $errors->has('terms') ? ' state-error' : '' }}">
                        <input type="checkbox" class="{{ $errors->has('terms') ? ' invalid' : '' }}" name="terms" id="terms" value="1"  {{ old('terms')==1? 'checked':'' }}>
                        <i></i>I agree with the <a href="#" data-toggle="modal" data-target="#myModal"> Terms and Conditions </a></label>
                    @if ($errors->has('terms'))
                        <em class="invalid" for="terms">{{ $errors->first('terms') }}</em>
                    @endif
                </section>
            </fieldset>
            <footer>
                <button type="submit" class="btn btn-primary">
                    Register
                </button>
            </footer>
        </form>

    </div>



    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Terms & Conditions</h4>
                </div>
                <div class="modal-body custom-scroll terms-body">

                    <div id="left">



                        <h1>SMARTADMIN TERMS & CONDITIONS TEMPLATE</h1>



                        <h2>Introduction</h2>

                        <p>These terms and conditions govern your use of this website; by using this website, you accept these terms and conditions in full.   If you disagree with these terms and conditions or any part of these terms and conditions, you must not use this website.</p>

                        <p>[You must be at least [18] years of age to use this website.  By using this website [and by agreeing to these terms and conditions] you warrant and represent that you are at least [18] years of age.]</p>


                        <h2>License to use website</h2>
                        <p>Unless otherwise stated, [NAME] and/or its licensors own the intellectual property rights in the website and material on the website.  Subject to the license below, all these intellectual property rights are reserved.</p>

                        <p>You may view, download for caching purposes only, and print pages [or [OTHER CONTENT]] from the website for your own personal use, subject to the restrictions set out below and elsewhere in these terms and conditions.</p>

                        <p>You must not:</p>
                        <ul>
                            <li>republish material from this website (including republication on another website);</li>
                            <li>sell, rent or sub-license material from the website;</li>
                            <li>show any material from the website in public;</li>
                            <li>reproduce, duplicate, copy or otherwise exploit material on this website for a commercial purpose;]</li>
                            <li>[edit or otherwise modify any material on the website; or]</li>
                            <li>[redistribute material from this website [except for content specifically and expressly made available for redistribution].]</li>
                        </ul>
                        <p>[Where content is specifically made available for redistribution, it may only be redistributed [within your organisation].]</p>

                        <h2>Acceptable use</h2>

                        <p>You must not use this website in any way that causes, or may cause, damage to the website or impairment of the availability or accessibility of the website; or in any way which is unlawful, illegal, fraudulent or harmful, or in connection with any unlawful, illegal, fraudulent or harmful purpose or activity.</p>

                        <p>You must not use this website to copy, store, host, transmit, send, use, publish or distribute any material which consists of (or is linked to) any spyware, computer virus, Trojan horse, worm, keystroke logger, rootkit or other malicious computer software.</p>

                        <p>You must not conduct any systematic or automated data collection activities (including without limitation scraping, data mining, data extraction and data harvesting) on or in relation to this website without [NAME'S] express written consent.</p>

                        <p>[You must not use this website to transmit or send unsolicited commercial communications.]</p>

                        <p>[You must not use this website for any purposes related to marketing without [NAME'S] express written consent.]</p>

                        <h2>[Restricted access</h2>

                        <p>[Access to certain areas of this website is restricted.]  [NAME] reserves the right to restrict access to [other] areas of this website, or indeed this entire website, at [NAME'S] discretion.</p>

                        <p>If [NAME] provides you with a user ID and password to enable you to access restricted areas of this website or other content or services, you must ensure that the user ID and password are kept confidential.</p>

                        <p>[[NAME] may disable your user ID and password in [NAME'S] sole discretion without notice or explanation.]</p>

                        <h2>[User content</h2>

                        <p>In these terms and conditions, â€œyour user contentâ€ means material (including without limitation text, images, audio material, video material and audio-visual material) that you submit to this website, for whatever purpose.</p>

                        <p>You grant to [NAME] a worldwide, irrevocable, non-exclusive, royalty-free license to use, reproduce, adapt, publish, translate and distribute your user content in any existing or future media.  You also grant to [NAME] the right to sub-license these rights, and the right to bring an action for infringement of these rights.</p>

                        <p>Your user content must not be illegal or unlawful, must not infringe any third party's legal rights, and must not be capable of giving rise to legal action whether against you or [NAME] or a third party (in each case under any applicable law).</p>

                        <p>You must not submit any user content to the website that is or has ever been the subject of any threatened or actual legal proceedings or other similar complaint.</p>

                        <p>[NAME] reserves the right to edit or remove any material submitted to this website, or stored on [NAME'S] servers, or hosted or published upon this website.</p>

                        <p>[Notwithstanding [NAME'S] rights under these terms and conditions in relation to user content, [NAME] does not undertake to monitor the submission of such content to, or the publication of such content on, this website.]</p>

                        <h2>No warranties</h2>

                        <p>This website is provided â€œas isâ€ without any representations or warranties, express or implied.  [NAME] makes no representations or warranties in relation to this website or the information and materials provided on this website.</p>

                        <p>Without prejudice to the generality of the foregoing paragraph, [NAME] does not warrant that:</p>
                        <ul>
                            <li>this website will be constantly available, or available at all; or</li>
                            <li>the information on this website is complete, true, accurate or non-misleading.</li>
                        </ul>
                        <p>Nothing on this website constitutes, or is meant to constitute, advice of any kind.  [If you require advice in relation to any [legal, financial or medical] matter you should consult an appropriate professional.]</p>

                        <h2>Limitations of liability</h2>

                        <p>[NAME] will not be liable to you (whether under the law of contact, the law of torts or otherwise) in relation to the contents of, or use of, or otherwise in connection with, this website:</p>
                        <ul>
                            <li>[to the extent that the website is provided free-of-charge, for any direct loss;]</li>
                            <li>for any indirect, special or consequential loss; or</li>
                            <li>for any business losses, loss of revenue, income, profits or anticipated savings, loss of contracts or business relationships, loss of reputation or goodwill, or loss or corruption of information or data.</li>
                        </ul>
                        <p>These limitations of liability apply even if [NAME] has been expressly advised of the potential loss.</p>

                        <h2>Exceptions</h2>

                        <p>Nothing in this website disclaimer will exclude or limit any warranty implied by law that it would be unlawful to exclude or limit; and nothing in this website disclaimer will exclude or limit [NAME'S] liability in respect of any:</p>
                        <ul>
                            <li>death or personal injury caused by [NAME'S] negligence;</li>
                            <li>fraud or fraudulent misrepresentation on the part of [NAME]; or</li>
                            <li>matter which it would be illegal or unlawful for [NAME] to exclude or limit, or to attempt or purport to exclude or limit, its liability.</li>
                        </ul>
                        <h2>Reasonableness</h2>

                        <p>By using this website, you agree that the exclusions and limitations of liability set out in this website disclaimer are reasonable.</p>

                        <p>If you do not think they are reasonable, you must not use this website.</p>

                        <h2>Other parties</h2>

                        <p>[You accept that, as a limited liability entity, [NAME] has an interest in limiting the personal liability of its officers and employees.  You agree that you will not bring any claim personally against [NAME'S] officers or employees in respect of any losses you suffer in connection with the website.]</p>

                        <p>[Without prejudice to the foregoing paragraph,] you agree that the limitations of warranties and liability set out in this website disclaimer will protect [NAME'S] officers, employees, agents, subsidiaries, successors, assigns and sub-contractors as well as [NAME].</p>

                        <h2>Unenforceable provisions</h2>

                        <p>If any provision of this website disclaimer is, or is found to be, unenforceable under applicable law, that will not affect the enforceability of the other provisions of this website disclaimer.</p>

                        <h2>Indemnity</h2>

                        <p>You hereby indemnify [NAME] and undertake to keep [NAME] indemnified against any losses, damages, costs, liabilities and expenses (including without limitation legal expenses and any amounts paid by [NAME] to a third party in settlement of a claim or dispute on the advice of [NAME'S] legal advisers) incurred or suffered by [NAME] arising out of any breach by you of any provision of these terms and conditions[, or arising out of any claim that you have breached any provision of these terms and conditions].</p>

                        <h2>Breaches of these terms and conditions</h2>

                        <p>Without prejudice to [NAME'S] other rights under these terms and conditions, if you breach these terms and conditions in any way, [NAME] may take such action as [NAME] deems appropriate to deal with the breach, including suspending your access to the website, prohibiting you from accessing the website, blocking computers using your IP address from accessing the website, contacting your internet service provider to request that they block your access to the website and/or bringing court proceedings against you.</p>

                        <h2>Variation</h2>

                        <p>[NAME] may revise these terms and conditions from time-to-time.  Revised terms and conditions will apply to the use of this website from the date of the publication of the revised terms and conditions on this website.  Please check this page regularly to ensure you are familiar with the current version.</p>

                        <h2>Assignment</h2>

                        <p>[NAME] may transfer, sub-contract or otherwise deal with [NAME'S] rights and/or obligations under these terms and conditions without notifying you or obtaining your consent.</p>

                        <p>You may not transfer, sub-contract or otherwise deal with your rights and/or obligations under these terms and conditions.</p>

                        <h2>Severability</h2>

                        <p>If a provision of these terms and conditions is determined by any court or other competent authority to be unlawful and/or unenforceable, the other provisions will continue in effect.  If any unlawful and/or unenforceable provision would be lawful or enforceable if part of it were deleted, that part will be deemed to be deleted, and the rest of the provision will continue in effect.</p>

                        <h2>Entire agreement</h2>

                        <p>These terms and conditions [, together with [DOCUMENTS],] constitute the entire agreement between you and [NAME] in relation to your use of this website, and supersede all previous agreements in respect of your use of this website.</p>

                        <h2>Law and jurisdiction</h2>

                        <p>These terms and conditions will be governed by and construed in accordance with [GOVERNING LAW], and any disputes relating to these terms and conditions will be subject to the [non-]exclusive jurisdiction of the courts of [JURISDICTION].</p>

                        <h2>About these website terms and conditions</h2><p>We created these website terms and conditions with the help of a free website terms and conditions form developed by Contractology and available at <a href="http://www.SmartAdmin.com">www.SmartAdmin.com</a>.
                            Contractology supply a wide variety of commercial legal documents, such as <a href="#">template data protection statements</a>.
                        </p>
                        <h2>[Registrations and authorisations</h2>

                        <p>[[NAME] is registered with [TRADE REGISTER].  You can find the online version of the register at [URL].  [NAME'S] registration number is [NUMBER].]</p>

                        <p>[[NAME] is subject to [AUTHORISATION SCHEME], which is supervised by [SUPERVISORY AUTHORITY].]</p>

                        <p>[[NAME] is registered with [PROFESSIONAL BODY].  [NAME'S] professional title is [TITLE] and it has been granted in [JURISDICTION].  [NAME] is subject to the [RULES] which can be found at [URL].]</p>

                        <p>[[NAME] subscribes to the following code[s] of conduct: [CODE(S) OF CONDUCT].  [These codes/this code] can be consulted electronically at [URL(S)].</p>

                        <p>[[NAME'S] [TAX] number is [NUMBER].]]</p>

                        <h2>[NAME'S] details</h2>

                        <p>The full name of [NAME] is [FULL NAME].</p>

                        <p>[[NAME] is registered in [JURISDICTION] under registration number [NUMBER].]</p>

                        <p>[NAME'S] [registered] address is [ADDRESS].</p>

                        <p>You can contact [NAME] by email to [EMAIL].</p>



                    </div>

                    <br><br>

                    <p><strong>By using this  WEBSITE TERMS AND CONDITIONS template document, you agree to the
                            <a href="#">terms and conditions</a> set out on
                            <a href="#">SmartAdmin.com</a>.  You must retain the credit
                            set out in the section headed "ABOUT THESE WEBSITE TERMS AND CONDITIONS".  Subject to the licensing restrictions, you should
                            edit the document, adapting it to the requirements of your jurisdiction, your business and your
                            website.  If you are not a lawyer, we recommend that you take professional legal advice in relation to the editing and
                            use of the template.</strong></p>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        Cancel
                    </button>
                    <button type="button" class="btn btn-primary" id="i-agree">
                        <i class="fa fa-check"></i> I Agree
                    </button>

                    <button type="button" class="btn btn-danger pull-left" id="print">
                        <i class="fa fa-print"></i> Print
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!--================================================== -->
@endsection
@section('validation_script')

    <script type="text/javascript">
        runAllForms();
        // Model i agree button
        $("#i-agree").click(function () {
            $this = $("#terms");
            if ($this.checked) {
                $('#myModal').modal('toggle');
            } else {
                $this.prop('checked', true);
                $('#myModal').modal('toggle');
            }
        });
        // Validation
        $(function () {
// Validation
            $("#smart-form-register").validate({
// Rules for form validation
                rules: {
                    username: {
                        required: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true,
                        minlength: 6
                    },
                    password_confirmation: {
                        required: true,
                        minlength: 6,
                        equalTo: '#password'
                    },
                    firstname: {
                        required: true
                    },
                    lastname: {
                        required: true
                    },
                    gender: {
                        required: true
                    },
                    terms: {
                        required: true
                    }
                },
// Messages for form validation
                messages: {
                    login: {
                        required: 'Please enter your login'
                    },
                    email: {
                        required: 'Please enter your email address',
                        email: 'Please enter a VALID email address'
                    },
                    password: {
                        required: 'Please enter your password'
                    },
                    password_confirmation: {
                        required: 'Please enter your password one more time',
                        equalTo: 'Please enter the same password as above'
                    },
                    firstname: {
                        required: 'Please enter your first name'
                    },
                    lastname: {
                        required: 'Please enter your last name'
                    },
                    gender: {
                        required: 'Please select your gender'
                    },
                    terms: {
                        required: 'You must agree with Terms and Conditions'
                    }
                },
// Ajax form submition
                submitHandler: function (form) {
                    $(form).ajaxSubmit({
                        success: function () {
                            $("#smart-form-register").addClass('submited');
                        }
                    });
                },
// Do not change code below
                errorPlacement: function (error, element) {
                    error.insertAfter(element.parent());
                }
            });
        });
    </script>
@endsection
