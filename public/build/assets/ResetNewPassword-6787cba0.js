import{_ as v}from"./GuestLayout-efb82eaa.js";import{T as h,a as p,h as b,w as l,b as r,u as o,Z as k,d as e,t as d,k as u,g as a,c as g,l as y}from"./app-81ecaf15.js";import{A as j}from"./ApplicationLogo-6710b6de.js";import{_ as f}from"./InputLabel-5c8c373c.js";import{_}from"./TextInput-184220bf.js";import"./_plugin-vue_export-helper-c27b6911.js";const V={class:"grid md:grid-cols-2"},B=e("div",{class:"flex justify-center item-center"},[e("div",{class:"h-screen bg-[#F5F6FA] m-4 rounded-[20px] w-screen"},[e("p",{class:"ml-12 mt-16 text-[42px] leading-[60px] font-jakarta-bold"},[a(" Welcome Back! "),e("br"),a(" Please sign in to your "),e("br"),e("u",null," Avenue Healthcare"),a(" account ")])])],-1),P={class:"flex items-center justify-center"},C={class:"w-full sm:max-w-lg"},F={class:"flex items-center justify-center mb-6"},N={class:"px-6 py-4 overflow-hidden shadow-[0_0_8px_4px_rgba(0,0,0,0.07)] rounded-2xl"},A={class:"text-center my-8"},R=e("h1",{class:"font-jakarta-semibold text-[28px]"},"Reset New Password",-1),$=e("p",{class:"font-jakarta-normal text-[#B2B2B2]"},[a("Enter a new password for"),e("br")],-1),E={class:"font-jakarta-normal"},S={class:"mt-4 mt-8"},q={class:"mt-4 mt-8"},M={key:0,class:"block mb-1 text-sm font-medium text-red-700 dark:text-red-500 mt-3 text-center"},O={class:"flex items-center justify-end mt-[42px] mb-[108px]"},Z={__name:"ResetNewPassword",props:{canResetPassword:{type:Boolean},status:{type:String},user:{type:Object},token:{type:Object}},setup(i){var m;const c=i,s=h({token:c.token,email:(m=c.user)==null?void 0:m.email,password:"",confirm_password:""});function w(){s.post(route("password.update"),{onFinish:()=>{},onError:x=>{console.log(s.errors.email)}})}return(x,t)=>(p(),b(v,null,{default:l(()=>[r(o(k),{title:"Forgot Password"}),e("div",V,[B,e("div",P,[e("div",C,[e("div",F,[r(j)]),e("div",N,[e("div",A,[R,$,e("p",E,d(i.user.email),1)]),e("div",S,[r(f,{value:"Password *",validation:!!o(s).errors.password},null,8,["validation"]),r(_,{type:"password",required:"",modelValue:o(s).password,"onUpdate:modelValue":t[0]||(t[0]=n=>o(s).password=n),placeholder:"Password"},u({_:2},[o(s).errors.password?{name:"validationMessage",fn:l(()=>[a(d(o(s).errors.password),1)]),key:"0"}:void 0]),1032,["modelValue"])]),e("div",q,[r(f,{value:"Confirm password *",validation:!!o(s).errors.confirm_password},null,8,["validation"]),r(_,{type:"password",required:"",modelValue:o(s).confirm_password,"onUpdate:modelValue":t[1]||(t[1]=n=>o(s).confirm_password=n),placeholder:"Confirm password"},u({_:2},[o(s).errors.confirm_password?{name:"validationMessage",fn:l(()=>[a(d(o(s).errors.confirm_password),1)]),key:"0"}:void 0]),1032,["modelValue"])]),o(s).errors.email?(p(),g("div",M,d(o(s).errors.email),1)):y("",!0),e("div",O,[e("button",{class:"bg-[#171F4C] w-full text-white font-bold rounded-lg py-[13px] font-[16px] font-jakarta-semibold leading-5",onClick:t[2]||(t[2]=n=>w())}," Reset password ")])])])])])]),_:1}))}};export{Z as default};
