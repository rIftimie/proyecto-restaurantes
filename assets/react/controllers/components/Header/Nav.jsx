import React from "react";
import NavButton from "../Buttons/NavButton";
import { useState } from "react";

// import { NavbarWrapper } from "./style/NavbarStyles";
import './style/navstyle.css';

const Nav = ({setcomponente})=>{
    return (
        <nav className='mainMenu'>
            <NavButton name='User' onClick={() => {setcomponente('User')}} />
            <NavButton name='Trabajadores' onClick={() => {}} />
            <NavButton name='Pedidos' onClick={() => {setcomponente('Orders')}} />
            <NavButton name='Trabajadores' onClick={() => {setcomponente('Table')}} />
            <NavButton name='Pedidos' onClick={() => {}} />
            <NavButton name='Productos' onClick={() => {}} />
            <NavButton name='Mesas' onClick={() => {}} />
        </nav>
    );
}
export default Nav;