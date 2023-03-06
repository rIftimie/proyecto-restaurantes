import React, { useState } from 'react';
import Header from '../../components/Header';
import NavButton from '../../components/Buttons/NavButton';

const AdminPages = () => {
  <>
    <Header />
    <nav className='mainMenu'>
      <NavButton name='Trabajadores' onClick={() => {}} />
      <NavButton name='Pedidos' onClick={() => {}} />
      <NavButton name='Productos' onClick={() => {}} />
      <NavButton name='Mesas' onClick={() => {}} />
    </nav>
  </>;
};

export default AdminPages;