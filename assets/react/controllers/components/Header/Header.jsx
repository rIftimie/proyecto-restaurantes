import React, { useState } from "react";
import MenuBurger from "./MenuBurger";
import UserIcon from "./UserIncon";
import RestaurantIcon from "./RestaurantIcon";
import { HeaderWrapper } from "./style/Header";

const Header = ()=>{
    const [open,setOpen] = useState(false);
    function handelClick (){
        setOpen(!open);
    }
    return(
        <header>
            <MenuBurger open={open} handelClick={handelClick}/>
            <UserIcon/>
            <RestaurantIcon/>
        </header>
    )
}

export default Header;