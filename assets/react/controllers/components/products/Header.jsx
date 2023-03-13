import React, { useEffect, useState } from 'react';

const Header = ({ orderProducts }) => {
  
	return <h4 className='mx-auto bg bg-dark w-25 text-center mt-2'> Precio total {orderProducts.reduce((curr,obj)=>(obj.price*obj.quantity+curr) ,0)}€ </h4>;
};

export default Header;
