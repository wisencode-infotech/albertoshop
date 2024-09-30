<div class="sticky hidden h-full bg-gray-100 lg:w-[380px] xl:block top-32 xl:top-24 2xl:top-22">
    <aside class="hidden h-full w-full bg-light lg:sticky lg:w-[380px] lg:bg-gray-100 xl:block  lg:top-22">
        <div data-overlayscrollbars-initialize="" class="os-theme-thin-dark" style="max-height:calc(100vh - 88px)" data-overlayscrollbars="host">
            <div class="os-size-observer">
                <div class="os-size-observer-listener ltr"></div>
            </div>
            <div data-overlayscrollbars-contents="" data-overlayscrollbars-viewport="scrollbarHidden" style="margin-right: 0px; margin-bottom: 0px; margin-left: 0px; top: 0px; right: auto; left: 0px; width: calc(100% + 0px); padding: 0px; overflow-y: scroll;">
                <div class="p-5">
                    <div class="grid grid-cols-2 gap-4">
                        @foreach($product_categories as $category)
                        <div class="text-center rounded bg-light py-4 flex flex-col items-center justify-start relative overflow-hidden cursor-pointer border-2 border-border-100 xl:border-transparent" role="button">
                            <div class="w-full h-20 flex items-center justify-center"><span class="w-10 h-10 inline-block">
                                <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-10 h-10">
                                        <g clip-path="url(#clip0_1005_1052)">
                                            <path d="M49.7124 15.6845L49.7124 15.6846L49.7165 15.6835C54.2611 14.4849 58.3744 13.4299 62.2196 14.1793C66.0431 14.9244 69.6376 17.4647 73.1063 23.559C74.8883 26.8266 76.3776 31.0927 77.5712 35.6677C78.7639 40.4389 79.5585 45.5065 79.7572 50.0741C79.9561 55.2447 79.4569 58.8954 78.379 61.3452L78.3779 61.3478C77.3039 63.8862 75.6554 65.2367 73.725 65.8168C71.8882 66.2991 69.7433 66.013 67.4764 65.1262C63.6253 63.5458 59.1639 60.179 54.7854 56.0993C51.6408 53.0573 45.7983 51.5603 40 51.5603C34.2018 51.5603 28.3592 53.0573 25.2146 56.0993C20.8356 60.1796 16.3736 63.5467 12.5222 65.1268L12.5222 65.1268L12.5183 65.1284C10.261 66.1098 8.11586 66.3006 6.27382 65.8164C4.25094 65.2378 2.69796 63.7929 1.62106 61.4447C0.542422 58.8935 0.0441438 55.2417 0.242829 50.1743C0.441477 45.6062 1.23624 40.538 2.42919 35.7662L2.42967 35.7642C3.52235 31.1949 5.11074 26.9279 6.894 23.6583C10.3627 17.5142 13.9573 14.9742 17.7804 14.2291C21.5917 13.4864 25.6651 14.516 30.1628 15.653L30.2856 15.684L30.2877 15.6845C30.5459 15.7468 30.8059 15.81 31.0675 15.8736C33.7288 16.5202 36.564 17.2091 39.4831 17.4828L39.4925 17.4837H39.5018H40.4982H40.5076L40.5169 17.4828C43.4361 17.2091 46.2713 16.5202 48.9326 15.8736C49.1942 15.81 49.4542 15.7468 49.7124 15.6845ZM72.8354 62.7148L72.8354 62.7148L72.8402 62.7134C73.9121 62.3918 74.7458 61.538 75.358 60.1095C76.2726 57.9754 76.6698 54.8503 76.4701 50.257L76.47 50.2566C76.27 45.856 75.4703 41.0601 74.3723 36.4683L74.3718 36.4664C73.2734 32.0727 71.873 28.168 70.1671 25.1573C67.4068 20.189 64.3982 18.0965 61.0971 17.5102C57.8848 16.9397 54.426 17.8049 50.7359 18.728C50.6619 18.7465 50.5879 18.7651 50.5137 18.7836L50.5123 18.784C47.4256 19.5805 44.2543 20.3729 40.6892 20.6708H40.689H40.6885H40.6879H40.6874H40.6868H40.6863H40.6858H40.6852H40.6847H40.6842H40.6836H40.6831H40.6826H40.682H40.6815H40.681H40.6805H40.68H40.6795H40.6789H40.6784H40.6779H40.6774H40.6769H40.6764H40.6759H40.6754H40.6749H40.6744H40.6739H40.6734H40.6729H40.6725H40.672H40.6715H40.671H40.6705H40.6701H40.6696H40.6691H40.6686H40.6682H40.6677H40.6672H40.6668H40.6663H40.6658H40.6654H40.6649H40.6645H40.664H40.6635H40.6631H40.6626H40.6622H40.6617H40.6613H40.6609H40.6604H40.66H40.6595H40.6591H40.6587H40.6582H40.6578H40.6574H40.6569H40.6565H40.6561H40.6557H40.6552H40.6548H40.6544H40.654H40.6536H40.6531H40.6527H40.6523H40.6519H40.6515H40.6511H40.6507H40.6503H40.6499H40.6495H40.6491H40.6487H40.6483H40.6479H40.6475H40.6471H40.6467H40.6463H40.6459H40.6455H40.6451H40.6447H40.6444H40.644H40.6436H40.6432H40.6428H40.6425H40.6421H40.6417H40.6413H40.641H40.6406H40.6402H40.6398H40.6395H40.6391H40.6387H40.6384H40.638H40.6376H40.6373H40.6369H40.6366H40.6362H40.6358H40.6355H40.6351H40.6348H40.6344H40.6341H40.6337H40.6334H40.633H40.6327H40.6323H40.632H40.6316H40.6313H40.6309H40.6306H40.6303H40.6299H40.6296H40.6292H40.6289H40.6286H40.6282H40.6279H40.6276H40.6272H40.6269H40.6266H40.6262H40.6259H40.6256H40.6252H40.6249H40.6246H40.6243H40.6239H40.6236H40.6233H40.623H40.6227H40.6223H40.622H40.6217H40.6214H40.621H40.6207H40.6204H40.6201H40.6198H40.6195H40.6192H40.6188H40.6185H40.6182H40.6179H40.6176H40.6173H40.617H40.6167H40.6163H40.616H40.6157H40.6154H40.6151H40.6148H40.6145H40.6142H40.6139H40.6136H40.6133H40.613H40.6127H40.6124H40.6121H40.6118H40.6115H40.6112H40.6109H40.6106H40.6103H40.61H40.6097H40.6094H40.6091H40.6088H40.6085H40.6082H40.6079H40.6076H40.6073H40.607H40.6067H40.6064H40.6061H40.6058H40.6055H40.6052H40.6049H40.6046H40.6043H40.604H40.6037H40.6035H40.6032H40.6029H40.6026H40.6023H40.602H40.6017H40.6014H40.6011H40.6008H40.6005H40.6002H40.5999H40.5996H40.5994H40.5991H40.5988H40.5985H40.5982H40.5979H40.5976H40.5973H40.597H40.5967H40.5964H40.5961H40.5958H40.5956H40.5953H40.595H40.5947H40.5944H40.5941H40.5938H40.5935H40.5932H40.5929H40.5926H40.5923H40.592H40.5917H40.5915H40.5912H40.5909H40.5906H40.5903H40.59H40.5897H40.5894H40.5891H40.5888H40.5885H40.5882H40.5879H40.5876H40.5873H40.587H40.5867H40.5864H40.5861H40.5858H40.5855H40.5852H40.5849H40.5846H40.5843H40.584H40.5837H40.5834H40.5831H40.5828H40.5825H40.5822H40.5819H40.5816H40.5813H40.581H40.5807H40.5804H40.5801H40.5797H40.5794H40.5791H40.5788H40.5785H40.5782H40.5779H40.5776H40.5773H40.577H40.5766H40.5763H40.576H40.5757H40.5754H40.5751H40.5747H40.5744H40.5741H40.5738H40.5735H40.5731H40.5728H40.5725H40.5722H40.5718H40.5715H40.5712H40.5709H40.5705H40.5702H40.5699H40.5695H40.5692H40.5689H40.5686H40.5682H40.5679H40.5676H40.5672H40.5669H40.5665H40.5662H40.5659H40.5655H40.5652H40.5648H40.5645H40.5641H40.5638H40.5635H40.5631H40.5628H40.5624H40.5621H40.5617H40.5614H40.561H40.5606H40.5603H40.5599H40.5596H40.5592H40.5589H40.5585H40.5581H40.5578H40.5574H40.557H40.5567H40.5563H40.5559H40.5556H40.5552H40.5548H40.5545H40.5541H40.5537H40.5533H40.5529H40.5526H40.5522H40.5518H40.5514H40.551H40.5507H40.5503H40.5499H40.5495H40.5491H40.5487H40.5483H40.5479H40.5475H40.5471H40.5467H40.5463H40.5459H40.5455H40.5451H40.5447H40.5443H40.5439H40.5435H40.5431H40.5426H40.5422H40.5418H40.5414H40.541H40.5406H40.5401H40.5397H40.5393H40.5388H40.5384H40.538H40.5376H40.5371H40.5367H40.5363H40.5358H40.5354H40.5349H40.5345H40.534H40.5336H40.5331H40.5327H40.5322H40.5318H40.5313H40.5309H40.5304H40.53H40.5295H40.529H40.5286H40.5281H40.5276H40.5272H40.5267H40.5262H40.5257H40.5253H40.5248H40.5243H40.5238H40.5233H40.5228H40.5223H40.5219H40.5214H40.5209H40.5204H40.5199H40.5194H40.5189H40.5184H40.5179H40.5173H40.5168H40.5163H40.5158H40.5153H40.5148H40.5143H40.5137H40.5132H40.5127H40.5122H40.5116H40.5111H40.5106H40.51H40.5095H40.5089H40.5084H40.5079H40.5073H40.5068H40.5062H40.5056H40.5051H40.5045H40.504H40.5034H40.5028H40.5023H40.5017H40.5011H40.5006H40.5H40.4994H40.4988H40.4982H39.4022H39.4016H39.401H39.4004H39.3999H39.3993H39.3987H39.3981H39.3976H39.397H39.3964H39.3959H39.3953H39.3948H39.3942H39.3937H39.3931H39.3926H39.392H39.3915H39.3909H39.3904H39.3899H39.3893H39.3888H39.3883H39.3877H39.3872H39.3867H39.3862H39.3856H39.3851H39.3846H39.3841H39.3836H39.3831H39.3826H39.3821H39.3815H39.3811H39.3805H39.3801H39.3796H39.3791H39.3786H39.3781H39.3776H39.3771H39.3766H39.3761H39.3756H39.3752H39.3747H39.3742H39.3737H39.3733H39.3728H39.3723H39.3719H39.3714H39.3709H39.3705H39.37H39.3695H39.3691H39.3686H39.3682H39.3677H39.3673H39.3668H39.3664H39.3659H39.3655H39.3651H39.3646H39.3642H39.3637H39.3633H39.3629H39.3624H39.362H39.3616H39.3611H39.3607H39.3603H39.3599H39.3595H39.359H39.3586H39.3582H39.3578H39.3574H39.357H39.3565H39.3561H39.3557H39.3553H39.3549H39.3545H39.3541H39.3537H39.3533H39.3529H39.3525H39.3521H39.3517H39.3513H39.3509H39.3505H39.3502H39.3498H39.3494H39.349H39.3486H39.3482H39.3479H39.3475H39.3471H39.3467H39.3463H39.346H39.3456H39.3452H39.3448H39.3445H39.3441H39.3437H39.3434H39.343H39.3426H39.3423H39.3419H39.3416H39.3412H39.3408H39.3405H39.3401H39.3398H39.3394H39.3391H39.3387H39.3384H39.338H39.3377H39.3373H39.337H39.3366H39.3363H39.3359H39.3356H39.3352H39.3349H39.3346H39.3342H39.3339H39.3335H39.3332H39.3329H39.3325H39.3322H39.3319H39.3315H39.3312H39.3309H39.3305H39.3302H39.3299H39.3296H39.3292H39.3289H39.3286H39.3283H39.3279H39.3276H39.3273H39.327H39.3266H39.3263H39.326H39.3257H39.3254H39.3251H39.3247H39.3244H39.3241H39.3238H39.3235H39.3232H39.3228H39.3225H39.3222H39.3219H39.3216H39.3213H39.321H39.3207H39.3204H39.3201H39.3197H39.3194H39.3191H39.3188H39.3185H39.3182H39.3179H39.3176H39.3173H39.317H39.3167H39.3164H39.3161H39.3158H39.3155H39.3152H39.3149H39.3146H39.3143H39.314H39.3137H39.3134H39.3131H39.3128H39.3125H39.3122H39.3119H39.3116H39.3113H39.311H39.3107H39.3104H39.3101H39.3098H39.3096H39.3093H39.309H39.3087H39.3084H39.3081H39.3078H39.3075H39.3072H39.3069H39.3066H39.3063H39.306H39.3057H39.3055H39.3052H39.3049H39.3046H39.3043H39.304H39.3037H39.3034H39.3031H39.3028H39.3025H39.3022H39.3019H39.3017H39.3014H39.3011H39.3008H39.3005H39.3002H39.2999H39.2996H39.2993H39.299H39.2987H39.2984H39.2981H39.2979H39.2976H39.2973H39.297H39.2967H39.2964H39.2961H39.2958H39.2955H39.2952H39.2949H39.2946H39.2943H39.294H39.2937H39.2934H39.2931H39.2928H39.2925H39.2922H39.292H39.2917H39.2914H39.2911H39.2908H39.2905H39.2902H39.2899H39.2896H39.2893H39.289H39.2887H39.2884H39.288H39.2877H39.2874H39.2871H39.2868H39.2865H39.2862H39.2859H39.2856H39.2853H39.285H39.2847H39.2844H39.2841H39.2838H39.2835H39.2831H39.2828H39.2825H39.2822H39.2819H39.2816H39.2813H39.281H39.2806H39.2803H39.28H39.2797H39.2794H39.2791H39.2787H39.2784H39.2781H39.2778H39.2775H39.2771H39.2768H39.2765H39.2762H39.2758H39.2755H39.2752H39.2748H39.2745H39.2742H39.2739H39.2735H39.2732H39.2729H39.2725H39.2722H39.2719H39.2715H39.2712H39.2708H39.2705H39.2702H39.2698H39.2695H39.2691H39.2688H39.2684H39.2681H39.2677H39.2674H39.267H39.2667H39.2663H39.266H39.2656H39.2653H39.2649H39.2646H39.2642H39.2639H39.2635H39.2631H39.2628H39.2624H39.262H39.2617H39.2613H39.2609H39.2606H39.2602H39.2598H39.2595H39.2591H39.2587H39.2583H39.258H39.2576H39.2572H39.2568H39.2564H39.2561H39.2557H39.2553H39.2549H39.2545H39.2541H39.2537H39.2533H39.2529H39.2525H39.2521H39.2518H39.2514H39.2509H39.2505H39.2501H39.2497H39.2493H39.2489H39.2485H39.2481H39.2477H39.2473H39.2469H39.2464H39.246H39.2456H39.2452H39.2448H39.2443H39.2439H39.2435H39.2431H39.2426H39.2422H39.2418H39.2413H39.2409H39.2404H39.24H39.2396H39.2391H39.2387H39.2382H39.2378H39.2373H39.2369H39.2364H39.236H39.2355H39.2351H39.2346H39.2341H39.2337H39.2332H39.2327H39.2323H39.2318H39.2313H39.2308H39.2304H39.2299H39.2294H39.2289H39.2284H39.228H39.2275H39.227H39.2265H39.226H39.2255H39.225H39.2245H39.224H39.2235H39.223H39.2225H39.222H39.2215H39.221H39.2204H39.2199H39.2194H39.2189H39.2184H39.2178H39.2173H39.2168H39.2163H39.2157H39.2152H39.2147H39.2141H39.2136H39.213H39.2125H39.2119H39.2114C35.746 20.373 32.575 19.5806 29.4882 18.7841C25.7128 17.7905 22.1799 16.8782 18.9022 17.473C15.6011 18.072 12.593 20.1896 9.83292 25.1573C8.12675 28.1684 6.72661 32.173 5.62865 36.4649C4.42936 41.0624 3.72992 45.9586 3.53002 50.2564L3.53 50.257C3.33035 54.8489 3.72719 57.9741 4.54191 59.909L4.54241 59.9102C5.15356 61.3362 5.98544 62.1896 7.05471 62.5124C8.22478 62.9353 9.68079 62.6088 11.2733 62.0116L11.2745 62.0111C14.7017 60.7007 18.8116 57.4877 22.8977 53.7006C26.7328 50.1606 33.3513 48.2735 40 48.2735C46.6501 48.2735 53.2639 50.1612 56.9973 53.8946L56.9972 53.8947L57.001 53.8982C60.992 57.6896 65.0996 60.7999 68.6231 62.2093L68.6271 62.2109C70.2371 62.8146 71.6797 63.0299 72.8354 62.7148Z" fill="currentColor" stroke="white" stroke-width="0.4"></path>
                                            <path d="M27.0461 28.9566L27.0594 29.1285L27.2313 29.1408C28.5644 29.236 29.7184 29.9024 30.695 30.7803C31.6545 31.7418 32.3266 33.1848 32.3266 34.7206C32.3266 36.2609 31.7505 37.6053 30.6913 38.6645L30.6911 38.6643L30.684 38.6722C29.8249 39.6268 28.5793 40.2041 27.2313 40.3004L27.0584 40.3128L27.046 40.4856C26.9508 41.8187 26.2844 42.9728 25.4065 43.9493C24.445 44.9088 23.002 45.581 21.4662 45.581C19.9259 45.581 18.5815 45.0049 17.5223 43.9456L17.5225 43.9454L17.5146 43.9384C16.56 43.0792 15.9827 41.8337 15.8864 40.4856L15.874 40.3119L15.7002 40.3003C14.2575 40.2042 13.1063 39.6294 12.1415 38.6645C11.1801 37.7031 10.5062 36.2584 10.5062 34.7206C10.5062 33.1803 11.0822 31.8359 12.1415 30.7766L12.2374 30.6807C13.206 29.8102 14.3598 29.2366 15.7011 29.1408L15.874 29.1284L15.8864 28.9555C15.9821 27.6159 16.6538 26.3639 17.5223 25.4955C18.4837 24.5341 19.9284 23.8602 21.4662 23.8602C23.0065 23.8602 24.3509 24.4363 25.4102 25.4955L25.5098 25.5952C26.3726 26.4579 26.9501 27.7085 27.0461 28.9566ZM14.6214 33.1953L14.6675 33.1493L23.1023 27.7038L23.1023 27.7038L23.1025 27.704L23.1029 27.7044L23.1033 27.7048L23.1038 27.7053L23.1039 27.7054L23.104 27.7054L23.104 27.7055L23.1042 27.7056L23.1045 27.706L23.1049 27.7064L23.105 27.7064L23.105 27.7065L23.1051 27.7065L23.1051 27.7066L23.1053 27.7068L23.1075 27.709L23.1106 27.7121L23.1147 27.7162L23.2019 27.8034L23.212 27.8135L23.2205 27.8248C23.5399 28.2507 23.7587 28.79 23.7587 29.3398V30.7348C23.7587 31.6277 24.4731 32.4281 25.452 32.4281H26.847C27.4943 32.4281 28.0445 32.646 28.483 33.0845C28.9216 33.523 29.1395 34.0732 29.1395 34.7206C29.1395 35.3679 28.9216 35.9181 28.483 36.3567C28.0445 36.7952 27.4943 37.0131 26.847 37.0131H25.452C24.5591 37.0131 23.7587 37.7275 23.7587 38.7063V40.0017C23.7587 40.649 23.5408 41.1992 23.1023 41.6378C22.6638 42.0763 22.1136 42.2942 21.4662 42.2942C20.8189 42.2942 20.2687 42.0763 19.8301 41.6378C19.3916 41.1992 19.1737 40.649 19.1737 40.0017V38.6067C19.1737 37.7138 18.4593 36.9134 17.4805 36.9134H16.0855C15.4381 36.9134 14.8879 36.6955 14.4494 36.257C14.1237 35.9313 13.793 35.385 13.793 34.7206C13.793 34.0732 14.0109 33.523 14.4494 33.0845L14.6214 33.1953Z" fill="currentColor" stroke="white" stroke-width="0.4"></path>
                                            <path d="M60.6256 27.6467C60.6256 29.4623 59.1538 30.9342 57.3381 30.9342C55.5225 30.9342 54.0506 29.4623 54.0506 27.6467C54.0506 25.8311 55.5225 24.3592 57.3381 24.3592C59.1538 24.3592 60.6256 25.8311 60.6256 27.6467Z" fill="currentColor" stroke="white" stroke-width="0.4"></path>
                                            <path d="M60.6256 41.7961C60.6256 43.6118 59.1538 45.0836 57.3381 45.0836C55.5225 45.0836 54.0506 43.6118 54.0506 41.7961C54.0506 39.9805 55.5225 38.5086 57.3381 38.5086C59.1538 38.5086 60.6256 39.9805 60.6256 41.7961Z" fill="currentColor" stroke="white" stroke-width="0.4"></path>
                                            <path d="M53.5509 34.7209C53.5509 36.5366 52.079 38.0084 50.2634 38.0084C48.4478 38.0084 46.9759 36.5366 46.9759 34.7209C46.9759 32.9053 48.4478 31.4334 50.2634 31.4334C52.079 31.4334 53.5509 32.9053 53.5509 34.7209Z" fill="currentColor" stroke="white" stroke-width="0.4"></path>
                                            <path d="M67.7003 34.7209C67.7003 36.5366 66.2285 38.0084 64.4128 38.0084C62.5972 38.0084 61.1253 36.5366 61.1253 34.7209C61.1253 32.9053 62.5972 31.4334 64.4128 31.4334C66.2285 31.4334 67.7003 32.9053 67.7003 34.7209Z" fill="currentColor" stroke="white" stroke-width="0.4"></path>
                                        </g>
                                    </svg>
                                </span>
                            </div>
                            <span class="text-sm font-semibold text-heading text-center px-2.5 block">{{ $category->name }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="os-scrollbar os-scrollbar-horizontal os-theme-dark os-scrollbar-auto-hide os-scrollbar-handle-interactive os-scrollbar-cornerless os-scrollbar-unusable os-scrollbar-auto-hide-hidden">
                <div class="os-scrollbar-track">
                    <div class="os-scrollbar-handle" style="width: 100%;"></div>
                </div>
            </div>
            <div class="os-scrollbar os-scrollbar-vertical os-theme-dark os-scrollbar-auto-hide os-scrollbar-handle-interactive os-scrollbar-cornerless os-scrollbar-visible os-scrollbar-auto-hide-hidden">
                <div class="os-scrollbar-track">
                    <div class="os-scrollbar-handle" style="height: 67.347%;"></div>
                </div>
            </div>
        </div>
    </aside>
</div>