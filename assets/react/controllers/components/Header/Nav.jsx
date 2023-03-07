import React from "react";
import NavButton from "../Buttons/NavButton";
// import { NavbarWrapper } from "./style/NavbarStyles";
import './style/navstyle.css';

const Nav = ()=>{
    return (
        <nav className='mainMenu'>
            <NavButton name='User' onClick={() => {}} />
            <NavButton name='Trabajadores' onClick={() => {}} />
            <NavButton name='Pedidos' onClick={() => {}} />
            <NavButton name='Productos' onClick={() => {}} />
            <NavButton name='Mesas' onClick={() => {}} />
        </nav>
    );
}
export default Nav;