import{_ as i,o as r,c as a,a as o,F as l,e as d,r as f,n as h,t as m}from"./app-ipiP95hW.js";const _={data(){return{tabs:[{name:"first",href:"www.google.com",isActive:!0},{name:"second",href:"www.google.com",isActive:!1}]}},created(){this.tabs=this.$children},methods:{selectTab(s){this.tabs.forEach(t=>{t.isActive=t.href==s.href})}}},p={class:"bg-white px-8 pt-2 shadow-md"},u={class:"-mb-px flex"},v=["href","onClick"],g={class:"tabs-details"};function w(s,t,x,b,n,c){return r(),a("div",null,[o("nav",p,[o("div",u,[(r(!0),a(l,null,d(n.tabs,e=>(r(),a("a",{class:h(["no-underline border-b-2 border-transparent uppercase tracking-wide font-bold text-xs py-3 mr-8",{"text-teal-dark":e.isActive,"text-grey-dark":e.isActive==!1}]),href:e.href,onClick:k=>c.selectTab(e),key:e.name},m(e.name),11,v))),128))])]),o("div",g,[f(s.$slots,"default")])])}const $=i(_,[["render",w]]);export{$ as default};
