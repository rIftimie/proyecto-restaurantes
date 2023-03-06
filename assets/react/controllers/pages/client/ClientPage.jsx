import React, { useState } from "react";
import PayButton from "../../components/stripe/PayButton";
import Header from "../../components/products/Header";
import Products from "../../components/products/Products";
import "../../App.css"

const ClientPage = () => {
  return (
    <div>
      <Header />
      <Products />
      <PayButton />
    </div>
  );
};

export default ClientPage;
