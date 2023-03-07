import React from "react";
import NavButton from "../Buttons/NavButton";

const Nav = ()=>{
    return (
        <nav className='mainMenu'>
            <NavButton name='Trabajadores' onClick={() => {}} />
            <NavButton name='Pedidos' onClick={() => {}} />
            <NavButton name='Productos' onClick={() => {}} />
            <NavButton name='Mesas' onClick={() => {}} />
        </nav>
    );
}
export default Nav;