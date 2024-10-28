<?php
return [
    "section1" => [
        "type" => "tab",
        "home_setting" => [
            "label" => "Home Setting",
            "type" => "fields",
            "fields" => [
                "slider_change_autoplay" => [
                    "type" => "slider",
                    "label" => "Slider Auto Play",
                    "desc" => "Slider Change time in second",
                    "default" => "4",
                    "min" => "1",
                    "max" => "120"
                ],
                "canonical_title" => [
                    "label" => "Canonical Title",
                    "default" => "Cornerstones Of Our Digital Marketing Agency",
                    "type" => "text"
                ],
                "features" => [
                    "type" => "addable-popup",
                    "label" => "Features",
                    "desc" => "Add your feature by clicking here",
                    "single_title" => "Feature",
                    "add_more_title" => "Add more Feature",
                    "template" => "feature_title",
                    "fields" => [
                        "feature_title" => [
                            "label" => "Feature Title",
                            "default" => "Feature Title",
                            "type" => "text",
                            "extra" => [
                                "required" => ""
                            ]
                        ],
                        "feature_description" => [
                            "label" => "Feature Description",
                            "type" => "textarea",
                            "extra" => [
                                "required" => ""
                            ]
                        ],
                        "feature_link" => [
                            "label" => "Feature Link",
                            "type" => "text",
                            "default" => "#"
                        ],
                        "feature_image" => [
                            "type" => "upload",
                            "label" => "Feature Images",
                            "desc" => "Select or upload your feature image from here.",
                            "default" => "",
                            "extra" => [
                                "required" => "",
                            ]
                        ]
                    ]
                ],
                "home_is_seo_section_enable" => [
                    "type" => "switch",
                    "label" => "Is Seo Form Section Enable?",
                    "default" => true,
                    "on_text" => "Yes",
                    "off_text" => "No"
                ],
                "home_seo_title" => [
                    "type" => "text",
                    "label" => "Seo Title",
                    "desc" => "Write your seo title here",
                    "default" => "Your SEO Score?"
                ],
                "home_seo_btn_title" => [
                    "type" => "text",
                    "label" => "Seo Button Title",
                    "desc" => "Write your seo title here",
                    "default" => "Check up now"
                ],
                "seo_feature_title" => [
                    "type" => "text",
                    "label" => "Seo Feature Title",
                    "default" => "DO YOU WANT TO BE SEEN? YOURE IN RIGHT PLACE!"
                ],
                "seo_feature_description" => [
                    "type" => "textarea",
                    "label" => "Seo Feature Description",
                    "default" => "SEOis a section of Search Engine Land that focuses not on search marketing advice but rather the search marketing industry."
                ],
                "seo_feature_image" => [
                    "type" => "upload",
                    "label" => "SEO Feature Image",
                    "desc" => "Select or upload your SEO feature image from here.",
                    "default" => "",
                ],
                "seo_feature_more_btn_is_enable" => [
                    "type" => "switch",
                    "label" => "SEO Feature Detail Button enable?",
                    "desc" => "Do you want to enable SEO Feature Detail Button?",
                    "default" => true,
                    "on_text" => "Yes",
                    "off_text" => "No",
                ],
                "seo_feature_more_btn_label" => [
                    "type" => "text",
                    "label" => "SEO Feature Detail Button Label",
                    "default" => "Learn more"
                ],
                "seo_feature_more_btn_link" => [
                    "type" => "text",
                    "label" => "SEO Feature Detail Button Link",
                    "default" => "#"
                ],
                "seo_feature_quote_btn_is_enable" => [
                    "type" => "switch",
                    "label" => "SEO Feature Quote Button enable?",
                    "desc" => "Do you want to enable SEO Feature Quote Button?",
                    "default" => true,
                    "on_text" => "Yes",
                    "off_text" => "No",
                ],
                "seo_feature_quote_btn_label" => [
                    "type" => "text",
                    "label" => "SEO Feature Quote Button Label",
                    "default" => "Learn quote"
                ],
                "seo_feature_quote_btn_link" => [
                    "type" => "text",
                    "label" => "SEO Feature Quote Button Link",
                    "default" => "#"
                ],
                "seo_features" => [
                    "type" => "addable-popup",
                    "label" => "SEO Features List",
                    "desc" => "Add your SEO feature by clicking here",
                    "single_title" => "SEO Feature",
                    "add_more_title" => "Add more SEO Feature",
                    "template" => "feature_title",
                    "fields" => [
                        "feature_title" => [
                            "label" => "SEO Feature Title",
                            "type" => "text",
                            "extra" => [
                                "required" => ""
                            ]
                        ],
                        "feature_icon" => [
                            "label" => "Feature Icon Image",
                            "type" => "upload",
                            "default" => ""
                        ],
                        "feature_link" => [
                            "label" => "Feature Link",
                            "type" => "text",
                            "default" => "#"
                        ],
                        "feature_description" => [
                            "label" => "SEO Feature Description",
                            "type" => "textarea",
                            "extra" => [
                                "required" => ""
                            ]
                        ],
                    ]
                ],
                "seo_marketing_subtitle" => [
                    "type" => "text",
                    "label" => "SEO Marketing Subtitle",
                    "default" => "WATCH THE VIDEO"
                ],
                "seo_marketing_title" => [
                    "type" => "text",
                    "label" => "SEO Marketing Subtitle",
                    "default" => "HOW TO WORKING NPTL SEO MARKETING"
                ],
                "seo_marketing_description" => [
                    "type" => "textarea",
                    "label" => "SEO Marketing Description",
                    "extra" => [
                        'class' => 'ckeditor'
                    ],
                    "default" => "our daily recap of search news. At the end of each business day, we'll email you a summary of th what happened in search. This will include all stories we've covered on Search Engine Land Land as well as headlines from sources from across the web. Anyone involved with digital marketinge deals with marketing technology every day. Keep up with the latest curves thrown by Google an Bing, whether they're tweaking Product Listing Ads, adjusting Enhanced Campaigns, or changiw the way ads display on various platforms.

Get the weekly recap on what's important from Search Engine Land's knowledgeable news team and our expert contributors. Everything you need to know about SEO, whether it's the latest thw news or how-tos from practitioners. Once a week, get the curated scoop from Search Engine ths Land's SEO newsletter. Reach your customers and potential customers on the popular socialalys platforms and."
                ],
                "seo_video_banner" => [
                    "type" => "upload",
                    "label" => "SEO Marketing Banner",
                    "default" => ""
                ],
                "seo_marketing_video_poster" => [
                    "type" => "upload",
                    "label" => "SEO Marketing Video Poster",
                    "default" => ""
                ],
                "seo_marketing_video" => [
                    "type" => "upload",
                    "label" => "SEO Marketing Video",
                    "default" => ""
                ],
                "home_service_title" => [
                    "type" => "text",
                    "label" => "SEO Marketing Subtitle",
                ],
                "home_service_subtitle" => [
                    "type" => "textarea",
                    "label" => "SEO Marketing Subtitle",
                ],
                "services" => [
                    "type" => "addable-popup",
                    "label" => "Footer top Services",
                    "desc" => "Add your footer top service by clicking here",
                    "single_title" => "Service",
                    "add_more_title" => "Add more Service",
                    "template" => "title",
                    "fields" => [
                        "title" => [
                            "label" => "Service Title",
                            "type" => "text",
                            "extra" => [
                                "required" => ""
                            ]
                        ],
                        "description" => [
                            "label" => "Service Description",
                            "type" => "textarea",
                            "extra" => [
                                "required" => ""
                            ]
                        ],
                        "link" => [
                            "label" => "Service Link",
                            "type" => "text",
                        ],
                        "service_image" => [
                            "type" => "upload",
                            "label" => "Service Images",
                            "desc" => "Select or upload your service image from here.",
                            "default" => "",
                            "extra" => [
                                "required" => "",
                            ]
                        ]
                    ]
                ],
                "home_service_video_link" => [
                    "type" => "text",
                    "label" => "Footer top Video link",
                ],
                "achievement_title" => [
                    "type" => "text",
                    "label" => "Achievement Title",
                    "default" => "OUR ACHIVMENT"
                ],
                "achievement_description" => [
                    "type" => "text",
                    "label" => "Achievement Description",
                    "default" => "SEO Boost is an experienced of online marketing firm with a big record of success!"
                ],
                "achievement_image" => [
                    "type" => "upload",
                    "label" => "Achievement Images",
                    "desc" => "Select or upload your service image from here.",
                    "default" => "",
                ],

                "total_project" => [
                    "type" => "number",
                    "label" => "Project Completed",
                    "default" => "222"
                ],
                "total_active_client" => [
                    "type" => "number",
                    "label" => "Active Client",
                    "default" => "333"
                ],
                "total_success_rate" => [
                    "type" => "number",
                    "label" => "Success Rate",
                    "default" => "98"
                ],
                "total_commitment" => [
                    "type" => "number",
                    "label" => "Commitment",
                    "default" => "100"
                ],
                "wcu_title" => [
                    "type" => "text",
                    "label" => "Why Choose Us Title",
                    "default" => "Why Choose NPTL?"
                ],
                "wcu_subtitle" => [
                    "type" => "text",
                    "label" => "Why Choose Us  Subtitle",
                    "default" => "Many Services! Big Claims Everywhere! Then, why us? Because..."
                ],
                "wcu_description" => [
                    "type" => "textarea",
                    "label" => "Why Choose Us  Description",
                    "default" => "",
                    "extra" => [
                        "class" => "ckeditor"
                    ]
                ],
                "wcu_image" => [
                    "type" => "upload",
                    "label" => "Why Choose Us Images",
                    "desc" => "Select or upload your service image from here.",
                    "default" => "",
                ],
                "case_subtitle" => [
                    "type" => "text",
                    "label" => "Case subtitle",
                    "default" => "CREATIVE WORK"
                ],
                "case_title" => [
                    "type" => "text",
                    "label" => "Case Title",
                    "default" => "Recent Case Studies"
                ],
                "case_show" => [
                    "type" => "slider",
                    "label" => "No of case show",
                    "default" => "3",
                    "min" => "1",
                    "max" => "9"
                ],
                "home_testimonial_style" => [
                    "type" => "select",
                    "label" => "Homepage Testimonial Style",
                    "default" => "bg-black",
                    "fields" => [
                        "" => "White Style",
                        "bg-black" => "Navy Blue Style"
                    ]
                ],
                "blog_title" => [
                    "type" => "text",
                    "label" => "Blog Title",
                    "default" => "Latest Blog"
                ],
                "blog_subtitle" => [
                    "type" => "text",
                    "label" => "Blog subtitle",
                    "default" => "Claritas est etiam processus dynamicus, qui sequitur mutationem"
                ],
                "blog_show" => [
                    "type" => "slider",
                    "label" => "No of blog show",
                    "default" => "6",
                    "min" => "1",
                    "max" => "9"
                ],
                "product_title" => [
                    "type" => "text",
                    "label" => "Product Title",
                    "default" => "Latest Product"
                ],
                "product_subtitle" => [
                    "type" => "text",
                    "label" => "Product subtitle",
                    "default" => "Claritas est etiam processus dynamicus, qui sequitur mutationem"
                ],
                "product_show" => [
                    "type" => "slider",
                    "label" => "No of product show",
                    "default" => "6",
                    "min" => "1",
                    "max" => "10"
                ],
                "branding_title" => [
                    "type" => "text",
                    "label" => "Branding Title",
                    "default" => "Valuable Clients"
                ],
                "branding_subtitle" => [
                    "type" => "text",
                    "label" => "Branding Subtitle",
                    "default" => "Claritas est etiam processus dynamicus, qui sequitur mutationem",
                ],
                "logos" => [
                    "type" => "uploads",
                    "label" => "Branding Logos",
                    "desc" => "Add or edit you logo form here size 170x95",
                    "default" => "",
                    "extra" => [
                        "required" => ""
                    ]
                ],
            ]
        ],
        "contact_setting" => [
            "label" => "Contact Page",
            "type" => "fields",
            "fields" => [
                "contact_banner_title" => [
                    "type" => "text",
                    "label" => "Contact Banner Title",
                    "default" => "CONTACT US"
                ],
                "contact_banner_subtitle" => [
                    "type" => "text",
                    "label" => "Contact Banner Subtitle",
                    "default" => "A World of Opportunities"
                ],
                "contact_banner_image" => [
                    "type" => "upload",
                    "label" => "Contact Banner Image",
                    "desc" => "Select or upload your link generate image from here.",
                    "default" => ""
                ],
                "contact_title" => [
                    "type" => "text",
                    "label" => "Contact Title",
                    "default" => "We Always Help"
                ],
                "contact_subtitle" => [
                    "type" => "text",
                    "label" => "Contact Subtitle",
                    "default" => "It is Easy To Reach Us For Any Digital Marketing Support Anytime From Anywhere"
                ],
                "contact_des_title" => [
                    "type" => "text",
                    "label" => "Contact Description Title",
                    "default" => "CONNECT WITH US"
                ],
                "contact_description" => [
                    "type" => "textarea",
                    "label" => "Contact Description",
                    "extra" => [
                        "class" => "ckeditor"
                    ]
                ],
                "contact_form_title" => [
                    "type" => "text",
                    "label" => "Contact Form Title",
                    "default" => "leave us a message"
                ],
                "contact_form_success_message" => [
                    "type" => "text",
                    "label" => "Contact Form Submit Success Message",
                    "default" => "Mail successfully send. We will contact you as soon as possible."
                ],
                "contact_branch_image" => [
                    "type" => "upload",
                    "label" => "Contact Branch Background Image",
                    "desc" => "Select or upload your image from here.",
                    "default" => ""
                ],
                "contact_branch_title" => [
                    "type" => "text",
                    "label" => "Contact Branch Title",
                    "default" => "Our branches"
                ],
                "contact_branch_subtitle" => [
                    "type" => "text",
                    "label" => "Contact Branch Subtitle",
                    "default" => "Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium."
                ],
                "contact_branches" => [
                    "type" => "addable-popup",
                    "label" => "Branches",
                    "desc" => "Add your branch by clicking here",
                    "single_title" => "Branch",
                    "add_more_title" => "Add more Branch",
                    "template" => "title",
                    "fields" => [
                        "title" => [
                            "label" => "Branch Title",
                            "type" => "text"
                        ],
                        "address" => [
                            "label" => "Address",
                            "type" => "textarea"
                        ],
                        "footer_address" => [
                            "label" => "Footer Address",
                            "type" => "textarea"
                        ],
                        "email" => [
                            "label" => "Branch Email",
                            "type" => "text"
                        ],
                        "mobile" => [
                            "label" => "Branch Mobile",
                            "type" => "text"
                        ],
                        "image" => [
                            "type" => "upload",
                            "label" => "Branch Image",
                            "desc" => "Select or upload your image from here."
                        ],
                    ]
                ],
                "contact_share_title" => [
                    "label" => "Share title",
                    "type" => "text",
                    "default" => "Share With Us"
                ],
                "contact_share_image" => [
                    "type" => "upload",
                    "label" => "Share Image",
                    "desc" => "Select or upload your image from here."
                ],
                "contact_location_title" => [
                    "type" => "text",
                    "label" => "Map Section Title",
                    "default" => "Map & Location"
                ],
                "contact_location_subtitle" => [
                    "type" => "text",
                    "label" => "Map Section Subtitle",
                    "default" => "Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium."
                ],
                "contact_location_latitude" => [
                    "type" => "text",
                    "label" => "Google Map Latitude",
                    "default" => "23.797424"
                ],
                "contact_location_longitude" => [
                    "type" => "text",
                    "label" => "Google Map Longitude",
                    "default" => "90.369409"
                ],
                "contact_seo_title" => [
                    "type" => "text",
                    "label" => "Contact Us SEO Title",
                ],
                "contact_meta_keywords" => [
                    "type" => "text",
                    "label" => "Contact Us Meta Keywords",
                ],
                "contact_meta_description" => [
                    "type" => "textarea",
                    "label" => "Contact Us Meta Description",
                ]
            ]
        ],
        "about_setting" => [
            "label" => "About Page",
            "type" => "fields",
            "fields" => [
                "about_banner_title" => [
                    "type" => "text",
                    "label" => "About Us Banner Title",
                    "default" => "ABOUT US"
                ],
                "about_banner_subtitle" => [
                    "type" => "text",
                    "label" => "About Us Banner Subtitle",
                    "default" => "A World of Opportunities"
                ],
                "about_banner_image" => [
                    "type" => "upload",
                    "label" => "About Us Banner Image",
                    "desc" => "Select or upload your link generate image from here.",
                    "default" => ""
                ],
                "wwr_title" => [
                    "label" => "Main Title",
                    "type" => "text",
                    "default" => "Who we are",
                    "desc" => "Add your about us page main title like 'Who we are'"
                ],
                "wwr_subtitle" => [
                    "label" => "Main Subtitle",
                    "type" => "text",
                    "default" => "",
                    "desc" => "Add your r about page main subtitle here."
                ],
                "wwr_description" => [
                    "label" => "Main Description",
                    "type" => "textarea",
                    "default" => "",
                    "extra" => [
                        "class" => "ckeditor"
                    ],
                    "desc" => "Add your about page main description here."
                ],
                "our_mission" => [
                    "label" => "Our Mission",
                    "type" => "textarea",
                    "default" => "",
                    "desc" => "Add your company mission.",
                    "extra" => [
                        "class" => "ckeditor"
                    ]
                ],
                "our_vision" => [
                    "label" => "Our Vision",
                    "type" => "textarea",
                    "default" => "",
                    "desc" => "Add your company vission.",
                    "extra" => [
                        "class" => "ckeditor"
                    ]
                ],
                "about_testimonial_style" => [
                    "type" => "select",
                    "label" => "Homepage Testimonial Style",
                    "fields" => [
                        "" => "White Style",
                        "bg-black" => "Navy Blue Style"
                    ]
                ],

                "about_page_add" => [
                    "type" => "upload",
                    "label" => "About Advertise Image",
                    "desc" => "Select or upload your link generate image from here.(319px , 389px)",
                    "default" => ""
                ],
                "about_page_add_link" => [
                    "type" => "text",
                    "label" => "About Advertise Image Link",
                    "default" => "#"
                ],

                "about_seo_title" => [
                    "type" => "text",
                    "label" => "About Us SEO Title",
                ],
                "about_meta_keywords" => [
                    "type" => "text",
                    "label" => "About Us Meta Keywords",
                ],
                "about_meta_description" => [
                    "type" => "textarea",
                    "label" => "About Us Meta Description",
                ],
            ]
        ],
        "faq_setting" => [
            "label" => "FAQ Page",
            "type" => "fields",
            "fields" => [
                "faq_banner_image" => [
                    "type" => "upload",
                    "label" => "FAQ Banner Image",
                    "desc" => "Select or upload your link generate image from here.",
                    "default" => ""
                ],
                "faq_sections" => [
                    "type" => "addable-popup",
                    "label" => "FAQ Sections",
                    "desc" => "Add your FAQ Section by clicking here",
                    "single_title" => "FAQ Section",
                    "add_more_title" => "Add FAQ Section",
                    "template" => "faq_section_title",
                    "fields" => [
                        "faq_section_title" => [
                            "label" => "Section Title",
                            "type" => "text"
                        ],
                        "faqs" => [
                            "type" => "addable-popup",
                            "label" => "FAQ",
                            "desc" => "Add your FAQ by clicking here",
                            "single_title" => "FAQ",
                            "add_more_title" => "Add FAQ",
                            "template" => "faq_title",
                            "fields" => [
                                "faq_title" => [
                                    "label" => "FAQ Title",
                                    "type" => "text"
                                ],
                                "faq_description" => [
                                    "label" => "FAQ Description",
                                    "type" => "textarea",
                                    "extra" => [
                                        "rows" => 4
                                    ]
                                ],
                            ]
                        ],
                    ]
                ],
                "faq_seo_title" => [
                    "type" => "text",
                    "label" => "FAQ SEO Title",
                ],
                "faq_meta_keywords" => [
                    "type" => "text",
                    "label" => "FAQ Meta Keywords",
                ],
                "faq_meta_description" => [
                    "type" => "textarea",
                    "label" => "FAQ Meta Description",
                ],
            ]
        ],
        "testimonial_setting" => [
            "label" => "Testimonial Setting",
            "type" => "fields",
            "fields" => [
                "testimonial_title" => [
                    "type" => "text",
                    "label" => "Testimonial Title",
                    "default" => "Happy Clients <br> About Us"
                ],
                "testimonials" => [
                    "type" => "addable-popup",
                    "label" => "Testimonial",
                    "desc" => "Add your testimonial by clicking here",
                    "single_title" => "testimonial",
                    "add_more_title" => "Add more Testimonial",
                    "template" => "title",
                    "fields" => [
                        "title" => [
                            "label" => "Client Name",
                            "type" => "text",
                            "extra" => [
                                "required" => ""
                            ]
                        ],
                        "description" => [
                            "label" => "Client Quote",
                            "type" => "textarea",
                            "extra" => [
                                "required" => ""
                            ]
                        ],
                        "testimonial_image" => [
                            "type" => "upload",
                            "label" => "Client Photo",
                            "desc" => "Select or upload your client photo from here.",
                            "default" => "",
                            "extra" => [
                                "required" => "",
                            ]
                        ],
                        "testimonial_logo" => [
                            "type" => "upload",
                            "label" => "Client Logo for Blue BG",
                            "desc" => "Select or upload your client logo from here.",
                            "default" => "",
                            "extra" => [
                                "required" => "",
                            ]
                        ],
                        "testimonial_logo_about" => [
                            "type" => "upload",
                            "label" => "Client Logo for White BG",
                            "desc" => "Select or upload your client logo from here.",
                            "default" => "",
                            "extra" => [
                                "required" => "",
                            ]
                        ]
                    ]
                ],
            ]
        ],
        "team_setting" => [
            "label" => "Team Setting",
            "type" => "fields",
            "fields" => [
                "team_banner_title" => [
                    "type" => "text",
                    "label" => "Team Banner Title",
                    "default" => "JOIN OUR TEAM"
                ],
                "team_banner_subtitle" => [
                    "type" => "text",
                    "label" => "Team Banner Subtitle",
                    "default" => "A World of Opportunities"
                ],
                "team_banner_image" => [
                    "type" => "upload",
                    "label" => "Team Banner Image",
                    "desc" => "Select or upload your link generate image from here.",
                    "default" => ""
                ],
                "team_title" => [
                    "type" => "text",
                    "label" => "Team Title",
                    "default" => "Expert Team"
                ],
                "team_subtitle" => [
                    "type" => "text",
                    "label" => "Team Subitle",
                    "default" => "Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium."
                ],
                "teams" => [
                    "type" => "addable-popup",
                    "label" => "Team",
                    "desc" => "Add your team by clicking here",
                    "single_title" => "Team Member Info",
                    "add_more_title" => "Add more team",
                    "template" => "title",
                    "fields" => [
                        "team_image" => [
                            "type" => "upload",
                            "label" => "Photo",
                            "desc" => "Select or upload your team member photo from here.",
                            "default" => "",
                            "extra" => [
                                "required" => "",
                            ]
                        ],
                        "title" => [
                            "label" => "Name",
                            "type" => "text",
                            "desc" => "Write your team member name here.",
                            "extra" => [
                                "required" => ""
                            ]
                        ],
                        "designation" => [
                            "label" => "Designation",
                            "type" => "text",
                            "desc" => "Write your team member designation here.",
                            "extra" => [
                                "required" => ""
                            ]
                        ],
                        "mobile" => [
                            "label" => "Mobile",
                            "type" => "text",
                            "desc" => "Write your team member mobile here."
                        ],
                        "email" => [
                            "label" => "Email",
                            "type" => "email",
                            "desc" => "Write your team member email here."
                        ],
                        "facebook" => [
                            "label" => "Facebook link",
                            "type" => "text",
                            "desc" => "Write your team member facebook link here."
                        ],
                        "twitter" => [
                            "label" => "Twitter link",
                            "type" => "text",
                            "desc" => "Write your team member twitter link here."
                        ],
                        "google_plus" => [
                            "label" => "Google Plus Link",
                            "type" => "text",
                            "desc" => "Write your team member google plus link here."
                        ],
                        "linkedin" => [
                            "label" => "LinkedIn Link",
                            "type" => "text",
                            "desc" => "Write your team member linkedIn link here."
                        ],

                    ]
                ],
                "team_seo_title" => [
                    "type" => "text",
                    "label" => "Team SEO Title",
                ],
                "team_meta_keywords" => [
                    "type" => "text",
                    "label" => "Team Meta Keywords",
                ],
                "team_meta_description" => [
                    "type" => "textarea",
                    "label" => "Team Meta Description",
                ]
            ]
        ],

        "blog_setting" => [
            "label" => "Blog Page",
            "type" => "fields",
            "fields" => [
                "blog_posts_per_page" => [
                    "type" => "slider",
                    "label" => "Blog posts per page",
                    "desc" => "Select posts per page that you need",
                    "default" => 5
                ],
                "blog_banner_title" => [
                    "type" => "text",
                    "label" => "Blog Banner Title",
                    "default" => "BLOG HOME"
                ],
                "blog_banner_subtitle" => [
                    "type" => "text",
                    "label" => "Blog Banner Subtitle",
                    "default" => "A World of Opportunities"
                ],
                "blog_banner_image" => [
                    "type" => "upload",
                    "label" => "Blog Banner Image",
                    "desc" => "Select or upload your link generate image from here.",
                    "default" => ""
                ],
                "blog_is_breadcrumb_enable" => [
                    "type" => "switch",
                    "label" => "Is Breadcrumb enable?",
                    "desc" => "Do you want to enable blog list page breadcrumb enable?",
                    "default" => false,
                    "on_text" => "Yes",
                    "off_text" => "No",
                ],
                "blog_ad_image" => [
                    "type" => "upload",
                    "label" => "Blog Advertise Image",
                    "desc" => "Select or upload your link generate image from here.",
                    "default" => ""
                ],
                "blog_seo_title" => [
                    "type" => "text",
                    "label" => "Blog SEO Title",
                ],
                "blog_meta_keywords" => [
                    "type" => "text",
                    "label" => "Blog Meta Keywords",
                ],
                "blog_meta_description" => [
                    "type" => "textarea",
                    "label" => "Blog Meta Description",
                ]
            ]
        ],
        "blog_detail_setting" => [
            "label" => "Blog Details",
            "type" => "fields",
            "fields" => [
                "blog_detail_banner_title" => [
                    "type" => "text",
                    "label" => "Blog Detail Banner Title",
                    "default" => "BLOG HOME"
                ],
                "blog_detail_banner_subtitle" => [
                    "type" => "text",
                    "label" => "Blog Detail Banner Subtitle",
                    "default" => "A World of Opportunities"
                ],
                "blog_detail_banner_image" => [
                    "type" => "upload",
                    "label" => "Blog Detail Banner Image",
                    "desc" => "Select or upload your link generate image from here.",
                    "default" => ""
                ],
                "blog_detail_is_breadcrumb_enable" => [
                    "type" => "switch",
                    "label" => "Is Breadcrumb enable?",
                    "desc" => "Do you want to enable blog single page breadcrumb enable?",
                    "default" => false,
                    "on_text" => "Yes",
                    "off_text" => "No",
                ],
                "blog_related_posts_per_page" => [
                    "type" => "slider",
                    "label" => "Related posts per page",
                    "desc" => "Select related posts per page that you need",
                    "default" => 2
                ],
                "blog_comments_per_page" => [
                    "type" => "slider",
                    "label" => "Blog Comments per page",
                    "desc" => "Select Comments per page that you need",
                    "default" => 5
                ],
            ]
        ],
        "blog_sidebar_setting" => [
            "label" => "Blog Sidebar",
            "type" => "fields",
            "fields" => [
                "blog_popular_is_enable" => [
                    "type" => "switch",
                    "label" => "Is blog popular posts enable?",
                    "desc" => "Do you want to enable blog popular post?",
                    "default" => true,
                    "on_text" => "Yes",
                    "off_text" => "No",
                ],
                "blog_popular_posts_per_page" => [
                    "type" => "slider",
                    "label" => "Blog popular posts per page",
                    "desc" => "Select posts per page that you need",
                    "default" => 5
                ],
                "blog_show_category" => [
                    "type" => "switch",
                    "label" => "Show Categories?",
                    "desc" => "Do you want to show categories?",
                    "default" => true,
                    "on_text" => "Yes",
                    "off_text" => "No",
                ],
                "blog_show_tag" => [
                    "type" => "switch",
                    "label" => "Show Tags?",
                    "desc" => "Do you want to show tags?",
                    "default" => true,
                    "on_text" => "Yes",
                    "off_text" => "No",
                ],
                "blog_sidebar_ad" => [
                    "type" => "upload",
                    "label" => "Blog Advertise Image",
                    "desc" => "Select or upload your link generate image from here.",
                    "default" => ""
                ],
                "blog_sidebar_ad_link" => [
                    "type" => "text",
                    "label" => "Blog Advertise Image Link",
                    "default" => "#"
                ],
            ]
        ],

        "product_setting" => [
            "label" => "Shop Page",
            "type" => "fields",
            "fields" => [
                "shop_page_per_product" => [
                    "type" => "slider",
                    "label" => "Shop Page Per Product",
                    "desc" => "Select shop page per product that you need",
                    "default" => 5
                ],
                "product_banner_title" => [
                    "type" => "text",
                    "label" => "Product Banner Title",
                    "default" => "PRODUCT HOME"
                ],
                "product_banner_subtitle" => [
                    "type" => "text",
                    "label" => "Product Banner Subtitle",
                    "default" => "A World of Opportunities"
                ],
                "product_banner_image" => [
                    "type" => "upload",
                    "label" => "Product Banner Image",
                    "desc" => "Select or upload your link generate image from here.",
                    "default" => ""
                ],
                "product_is_breadcrumb_enable" => [
                    "type" => "switch",
                    "label" => "Is Breadcrumb enable?",
                    "desc" => "Do you want to enable product list page breadcrumb enable?",
                    "default" => false,
                    "on_text" => "Yes",
                    "off_text" => "No",
                ],
                "product_ad_image" => [
                    "type" => "upload",
                    "label" => "Product Advertise Image",
                    "desc" => "Select or upload your link generate image from here.",
                    "default" => ""
                ],
                "product_seo_title" => [
                    "type" => "text",
                    "label" => "Product SEO Title",
                ],
                "product_meta_keywords" => [
                    "type" => "text",
                    "label" => "Product Meta Keywords",
                ],
                "product_meta_description" => [
                    "type" => "textarea",
                    "label" => "Product Meta Description",
                ]
            ]
        ],
        "product_detail_setting" => [
            "label" => "Shop Details Page",
            "type" => "fields",
            "fields" => [
                "product_detail_banner_title" => [
                    "type" => "text",
                    "label" => "Product Detail Banner Title",
                    "default" => "PRODUCT HOME"
                ],
                "product_detail_banner_subtitle" => [
                    "type" => "text",
                    "label" => "Product Detail Banner Subtitle",
                    "default" => "A World of Opportunities"
                ],
                "product_detail_banner_image" => [
                    "type" => "upload",
                    "label" => "Product Detail Banner Image",
                    "desc" => "Select or upload your link generate image from here.",
                    "default" => ""
                ],
                "product_detail_is_breadcrumb_enable" => [
                    "type" => "switch",
                    "label" => "Is Breadcrumb enable?",
                    "desc" => "Do you want to enable product single page breadcrumb enable?",
                    "default" => false,
                    "on_text" => "Yes",
                    "off_text" => "No",
                ],
                "product_related_per_page" => [
                    "type" => "slider",
                    "label" => "Related posts per page",
                    "desc" => "Select related posts per page that you need",
                    "default" => 2
                ],
                "product_comments_per_page" => [
                    "type" => "slider",
                    "label" => "Product Comments per page",
                    "desc" => "Select Comments per page that you need",
                    "default" => 5
                ],
                "product_best_sale_is_enable" => [
                    "type" => "switch",
                    "label" => "Is product best sales enable?",
                    "desc" => "Do you want to enable product best sales?",
                    "default" => true,
                    "on_text" => "Yes",
                    "off_text" => "No",
                ],
                "product_best_sale_per_page" => [
                    "type" => "slider",
                    "label" => "Product best sales per page",
                    "desc" => "Select posts per page that you need",
                    "default" => 6
                ],
                "product_detail_add" => [
                    "type" => "upload",
                    "label" => "Product Advertise Image",
                    "desc" => "Select or upload your link generate image from here.(319px , 319px)",
                    "default" => ""
                ],
                "product_detail_add_link" => [
                    "type" => "text",
                    "label" => "Product Advertise Image Link",
                    "default" => "#"
                ],
            ]
        ],
        "product_sidebar_setting" => [
            "label" => "Shop Sidebar",
            "type" => "fields",
            "fields" => [
                "product_special_is_enable" => [
                    "type" => "switch",
                    "label" => "Is product special posts enable?",
                    "desc" => "Do you want to enable product special post?",
                    "default" => true,
                    "on_text" => "Yes",
                    "off_text" => "No",
                ],
                "product_special_per_page" => [
                    "type" => "slider",
                    "label" => "Product special per page",
                    "desc" => "Select posts per page that you need",
                    "default" => 5
                ],
                "product_show_category" => [
                    "type" => "switch",
                    "label" => "Show Categories?",
                    "desc" => "Do you want to show categories?",
                    "default" => true,
                    "on_text" => "Yes",
                    "off_text" => "No",
                ],
                "product_show_tag" => [
                    "type" => "switch",
                    "label" => "Show Tags?",
                    "desc" => "Do you want to show tags?",
                    "default" => true,
                    "on_text" => "Yes",
                    "off_text" => "No",
                ],
                "product_show_brand" => [
                    "type" => "switch",
                    "label" => "Show Brands?",
                    "desc" => "Do you want to show brands?",
                    "default" => true,
                    "on_text" => "Yes",
                    "off_text" => "No",
                ],
                "product_show_size" => [
                    "type" => "switch",
                    "label" => "Show Sizes?",
                    "desc" => "Do you want to show sizes?",
                    "default" => true,
                    "on_text" => "Yes",
                    "off_text" => "No",
                ],
                "product_show_color" => [
                    "type" => "switch",
                    "label" => "Show Colors?",
                    "desc" => "Do you want to show colors?",
                    "default" => true,
                    "on_text" => "Yes",
                    "off_text" => "No",
                ],
                "product_sidebar_add" => [
                    "type" => "upload",
                    "label" => "Product Advertise Image",
                    "desc" => "Select or upload your link generate image from here.(319px , 389px)",
                    "default" => ""
                ],
                "product_sidebar_add_link" => [
                    "type" => "text",
                    "label" => "Product Advertise Image Link",
                    "default" => "#"
                ],
            ]
        ],
        "order_setting" => [
            "label" => "Order Info",
            "type" => "fields",
            "fields" => [
                "order_posts_per_page" => [
                    "type" => "slider",
                    "label" => "Order per page",
                    "desc" => "Select order per page that you need",
                    "default" => 5
                ],
                "invoice_signature" => [
                    "type" => "upload",
                    "label" => "Invoice Signature",
                    "desc" => "Select or upload your link generate image from here.",
                    "default" => ""
                ],
                "invoice_approved_by_name" => [
                    "type" => "text",
                    "label" => "Invoice approved by Name",
                    "default" => "nptl author"
                ],
                "invoice_approved_by_designation" => [
                    "type" => "text",
                    "label" => "Invoice approved by Designation",
                    "default" => "Director of Development"
                ],
                "invoice_banner_title" => [
                    "type" => "text",
                    "label" => "Invoice Banner Title",
                    "default" => "ORDER DETAILS",
                ],
                "invoice_banner_subtitle" => [
                    "type" => "text",
                    "label" => "Invoice Banner Subtitle",
                    "default" => "If you're struggling to get more information
"
                ],
                "invoice_banner_image" => [
                    "type" => "upload",
                    "label" => "Invoice Banner Image",
                    "desc" => "Select or upload your link generate image from here.",
                    "default" => ""
                ]
            ]
        ],
        "social_setting" => [
            "label" => "Socials Settings",
            "type" => "fields",
            "fields" => [
                "social_facebook" => [
                    "type" => "text",
                    "label" => "Facebook Link",
                    "default" => "",
                    "desc" => "Please leave empty if you want to hide this social."
                ],
                "social_twitter" => [
                    "type" => "text",
                    "label" => "Twitter Link",
                    "default" => "",
                    "desc" => "Please leave empty if you want to hide this social."
                ],
                "social_linkedin" => [
                    "type" => "text",
                    "label" => "LinkedIn Link",
                    "default" => ""
                ],
                "social_google_plus" => [
                    "type" => "text",
                    "label" => "Google Plus Link",
                    "default" => "",
                    "desc" => "Please leave empty if you want to hide this social."
                ],
                "social_github" => [
                    "type" => "text",
                    "label" => "Github Link",
                    "default" => "",
                    "desc" => "Please leave empty if you want to hide this social."
                ],
                "social_pinterest" => [
                    "type" => "text",
                    "label" => "Pinterest Link",
                    "default" => "",
                    "desc" => "Please leave empty if you want to hide this social."
                ],
                "social_behance" => [
                    "type" => "text",
                    "label" => "Behance Link",
                    "default" => "",
                    "desc" => "Please leave empty if you want to hide this social."
                ],
                "social_dribbble" => [
                    "type" => "text",
                    "label" => "Dribbble Link",
                    "default" => "",
                    "desc" => "Please leave empty if you want to hide this social."
                ],
                "social_instagram" => [
                    "type" => "text",
                    "label" => "Instagram Link",
                    "default" => "",
                    "desc" => "Please leave empty if you want to hide this social."
                ],
                "social_youtube" => [
                    "type" => "text",
                    "label" => "Youtube Link",
                    "default" => "",
                    "desc" => "Please leave empty if you want to hide this social."
                ]
            ]
        ],
        "footer_setting" => [
            "label" => "Footer Setting",
            "type" => "fields",
            "fields" => [
                "footer_logo" => [
                    "type" => "upload",
                    "label" => "Footer Logo",
                    "desc" => "Add your footer logo here"
                ],
                "footer_widget2_title" => [
                    "type" => "text",
                    "label" => "Footer Widget 2 : Title",
                    "default" => "COMPANY",
                ],
                "footer_widget2_description" => [
                    "type" => "textarea",
                    "label" => "Footer Widget 2 : Content",
                    "extra" => [
                        'class' => 'ckeditor'
                    ],
                    "default" => '',
                ],
                "footer_widget3_title" => [
                    "type" => "text",
                    "label" => "Footer Widget 3 : Title",
                    "default" => "MY ACCOUNT",
                ],
                "footer_widget3_description" => [
                    "type" => "textarea",
                    "label" => "Footer Widget 3 : Content",
                    "extra" => [
                        'class' => 'ckeditor'
                    ],
                    "default" => '',
                ],
                "footer_widget4_title" => [
                    "type" => "text",
                    "label" => "Footer Widget 4 : Title",
                    "default" => "SUPPORT",
                ],
                "footer_widget4_description" => [
                    "type" => "textarea",
                    "label" => "Footer Widget 4 : Content",
                    "extra" => [
                        'class' => 'ckeditor'
                    ],
                    "default" => '',
                ],

                "copyright" => [
                    "type" => "textarea",
                    "label" => "Copyright",
                    "default" => "© " . date("Y") . " | All rights reserved.",
                    "desc" => "Add your copyright text here.",
                    "extra" => [
                        "required" => "",
                        "placeholder" => "Add your copyright text here.",
                        "id" => "",
                        "class" => ""
                    ]
                ],
            ]
        ],
        "popup_setting" => [
            "label" => "Pop Up Setting",
            "type" => "fields",
            "fields" => [
                "newsletter_pop_is_enable" => [
                    "type" => "switch",
                    "label" => "Newsletter Pop Up enable?",
                    "desc" => "Do you want to enable Newsletter Pop Up?",
                    "default" => true,
                    "on_text" => "Yes",
                    "off_text" => "No",
                ],
                "newsletter_pop_title" => [
                    "type" => "text",
                    "label" => "Newsletter Pop Up Title",
                    "default" => "Join Our Newsletter",
                ],
                "newsletter_pop_description" => [
                    "type" => "textarea",
                    "label" => "Newsletter Pop Up Description",
                    "extra" => [
                        'class' => 'ckeditor'
                    ],
                    "default" => '<p>
                We really care about you and your website as much as you do. from us you get 100% free support.
            </p>',
                ],
                "newsletter_success_title" => [
                    "type" => "text",
                    "label" => "Newsletter Success Title",
                    "default" => "Thank You For Subscribing!",
                ],
                "newsletter_success_description" => [
                    "type" => "textarea",
                    "label" => "Newsletter Success Description",
                    "default" => "You're just one step away from being one of our dear susbcribers.<br>Please check the Email provided and confirm your susbcription.",
                ],
                "newsletter_already_success_title" => [
                    "type" => "text",
                    "label" => "Newsletter Already Subscribed Title",
                    "default" => "Thank You For Your Efforts!",
                ],
                "newsletter_already_success_description" => [
                    "type" => "textarea",
                    "label" => "Newsletter Already Subscribed Description",
                    "default" => "You Already Subscribed To Our Newsletter!",
                ],
                "newsletter_form_success_message" => [
                    "type" => "text",
                    "label" => "Newsletter Form Submit Success Message",
                    "default" => "Subscribed successfully."
                ],
                "offer_is_enable" => [
                    "type" => "switch",
                    "label" => "Offer Pop Up enable?",
                    "desc" => "Do you want to enable Offer Pop Up?",
                    "default" => true,
                    "on_text" => "Yes",
                    "off_text" => "No",
                ],
                "offer_title" => [
                    "type" => "text",
                    "label" => "Offer Pop Up Title",
                    "default" => "1st Order To 30% Off",
                ],
                "offer_description" => [
                    "type" => "textarea",
                    "label" => "Offer Pop Up Description",
                    "extra" => [
                        'class' => 'ckeditor'
                    ],
                    "default" => '<p>
                As content marketing continues to drive results for businesses trying to reach their audience
            </p>
            <a href="#">Get More</a>',
                ],
            ]
        ],
        "style_n_script_setting" => [
            "label" => "Style & Scripts Setting",
            "type" => "fields",
            "fields" => [
                "google_analytic_code" => [
                    "type" => "textarea",
                    "label" => "Google Analytic Code",
                    "desc" => "Add your google analytic code here.",
                    "default" => '<script>
        (function(i,s,o,g,r,a,m){i[\'GoogleAnalyticsObject\']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,\'script\',\'https://www.google-analytics.com/analytics.js\',\'ga\');

        ga(\'create\', \'UA-XXXXXXXX-X\', \'auto\');
        ga(\'send\', \'pageview\');
        ga(\'require\', \'linkid\', \'linkid.js\');
        ga(\'require\', \'displayfeatures\');
        setTimeout("ga(\'send\',\'event\',\'Profitable Engagement\',\'time on page more than 30 seconds\')",30000);
    </script>'
                ],
                "mrks_theme_custom_css" => [
                    "type" => "textarea",
                    "label" => "Custom CSS",
                    "desc" => "Write your custom css here.",
                    "default" => ''
                ],
                "mrks_theme_custom_js" => [
                    "type" => "textarea",
                    "label" => "Custom Script",
                    "desc" => "Write your custom js here.",
                    "default" => ''
                ]
            ],
        ],
        "other_setting" => [
            "label" => "Other Settings",
            "type" => "fields",
            "fields" => [
                "checkout_is_breadcrumb_enable" => [
                    "type" => "switch",
                    "label" => "Is Breadcrumb enable?",
                    "desc" => "Do you want to enable checkout page breadcrumb enable?",
                    "default" => false,
                    "on_text" => "Yes",
                    "off_text" => "No",
                ],
                "checkout_banner_title" => [
                    "type" => "text",
                    "label" => "Checkout Banner Title",
                    "default" => "Checkout"
                ],
                "checkout_banner_subtitle" => [
                    "type" => "text",
                    "label" => "Checkout Banner Subtitle",
                    "default" => "A World of Opportunities"
                ],
                "checkout_banner_image" => [
                    "type" => "upload",
                    "label" => "Checkout Banner Image",
                    "desc" => "Select or upload your link generate image from here.",
                    "default" => ""
                ],
                "checkout_email_label" => [
                    "type" => "text",
                    "label" => "Checkout Banner Subtitle",
                    "default" => "Please provide your email address :"
                ],
                "checkout_email_description" => [
                    "type" => "textarea",
                    "label" => "Checkout Banner Subtitle",
                    "default" => "Please enter an email address you check regularly, as we use this to send updates regarding your job. this email address with the service provider."
                ],
                "checkout_payment_description" => [
                    "type" => "textarea",
                    "label" => "Checkout Payment Subtitle",
                    "default" => ""
                ],

            ]
        ],
    ]
];