import React from 'react';

//Button component that will be used to navigate between the different pages
const NavButton = ({ name, onClick }) => {
  return (
    <button className='navButton' onClick={onClick}>
      {name}
    </button>
  );
};
