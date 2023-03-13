import React, { useEffect, useState } from 'react';
import Header from '../../components/products/Header';
import Products from '../../components/products/Products';
import { postOrder } from '../../helpers/orders';
import './css/client.css';

const ClientPage = ({ idres, idtable, menu }) => {
	const [orderProducts, setOrderProducts] = useState([]);
	const [charge, setCharge] = useState(true);
	const [show, setShow] = useState(false);

	const handleClickPay = async () => {
		if (orderProducts.length) {
			setCharge(false);
			await postOrder(orderProducts)
				.then((res) => {
					window.location.href =
						'http://localhost:8000/orders/' + res[0].id + '/pay';
				})
				.catch((error) => {
					setCharge(true);
					console.log(error);
				});
		}
	};

	return (
		<div>
			{charge && show && <Header orderProducts={orderProducts} />}
			{charge && (
				<Products
					idres={idres}
					idtable={idtable}
					orderProducts={orderProducts}
					setOrderProducts={setOrderProducts}
					setShow={setShow}
					paying={false}
					menu={menu}
				/>
			)}
			{charge && (
				<button
					type="button"
					className="m-3 btn btn-outline-success fw-bold"
					onClick={handleClickPay}
				>
					Pagar
				</button>
			)}
			{!show && charge && <p>Loading...</p>}
		</div>
	);
};

export default ClientPage;
