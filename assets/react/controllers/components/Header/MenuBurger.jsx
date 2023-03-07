import React from "react";
import Nav from "./Nav";
import styled from "styled-components";

// const MenuButtonWrapper = styled.button`
//   border: none;
//   box-shadow: 0px 0px 1px rgb(50, 50, 50);
//   margin-top: 1.3rem;

//   @media only screen and (min-width: 624px) {
//     display: none;
//   }
// `;
const MenuBurger = ({open,handelClick})=>{
    console.log(open);
    return !open ?(
        <button onClick={handelClick}>
            <svg viewBox="0 0 100 80" width="30" height="30" fill="#2962ff">
                    <rect width="90" height="10" />
                    <rect y="30" width="80" height="10" />
                    <rect y="60" width="70" height="10" />
            </svg>
        </button>
    ) :(
        <>
            <button onClick={handelClick}>
                <svg
                    className="svg-icon"
                    width="30"
                    height="30"
                    viewBox="0 0 20 20"
                    fill="#2962ff">
                    <path d="M15.898,4.045c-0.271-0.272-0.713-0.272-0.986,0l-4.71,4.711L5.493,4.045c-0.272-0.272-0.714-0.272-0.986,0s-0.272,0.714,0,0.986l4.709,4.711l-4.71,4.711c-0.272,0.271-0.272,0.713,0,0.986c0.136,0.136,0.314,0.203,0.492,0.203c0.179,0,0.357-0.067,0.493-0.203l4.711-4.711l4.71,4.711c0.137,0.136,0.314,0.203,0.494,0.203c0.178,0,0.355-0.067,0.492-0.203c0.273-0.273,0.273-0.715,0-0.986l-4.711-4.711l4.711-4.711C16.172,4.759,16.172,4.317,15.898,4.045z" />
                </svg>
            </button><br></br>
            <Nav/>
        </>
    )
}
export default MenuBurger;