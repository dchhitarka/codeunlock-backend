import{r,j as s}from"./index-DcZMDsWX.js";const d="/assets/grid-active-eQLRjtyr.png",c="/assets/grid-B4e_YhIH.png",o="/assets/list-active-DIWyEEtW.png",g="/assets/list-DGUQCsI8.png",m=()=>{const[a,t]=r.useState(c),[l,i]=r.useState(o),e=n=>{switch(n){case"grid":document.querySelector(".posts").classList.add("grid"),t(d),i(g);break;case"list":document.querySelector(".posts").classList.remove("grid"),t(c),i(o);break}};return s.jsxs("div",{className:"post-filter",children:[s.jsx("abbr",{title:"Grid View",children:s.jsx("img",{src:a,alt:"Grid",className:"filter-icon",width:"25",height:"25",onClick:()=>e("grid")})}),s.jsx("abbr",{title:"List View",children:s.jsx("img",{src:l,alt:"List",className:"filter-icon",width:"25",height:"25",onClick:()=>e("list")})})]})};export{m as P};
