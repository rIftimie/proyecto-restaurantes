import React, { useState } from 'react';
import { changeStockProduct } from '../../helpers/kitchen';

const SelectProducts = ({ useStateProduct }) => {
	const [selectedProduct, setSelectedProduct] = useState(null);
	const [quantity, setQuantity] = useState(0);
	const { products } = useStateProduct;

	const handleConfirm = async () => {
		try {
			await changeStockProduct(selectedProduct, quantity); // actualiza el estado en el servidor
		} catch (error) {
			console.error(error);
		}
	};

	const handleQuantityChange = (event) => {
		const newQuantity = event.target.value;
		setQuantity(newQuantity);
	};

	const handleProductChange = (event) => {
		setSelectedProduct(JSON.parse(event.target.value));
	};

	const handleIncreaseClick = () => {
		const newQuantity = quantity + 1;
		setQuantity(newQuantity);
	};

	const handleDecreaseClick = () => {
		const newQuantity = quantity - 1;
		setQuantity(newQuantity);
	};

	return (
		<form className="align-items-center col-8 d-flex justify-content-start">
			<label htmlFor="product-select">Modificar Stock:</label>
			<select
				id="product-select"
				onChange={handleProductChange}
				value={selectedProduct ? JSON.stringify(selectedProduct) : ''}
				className="form-select"
			>
				<option value="" defaultValue disabled hidden>
					Please select a product.
				</option>
				{products.map((product) => (
					<option
						className="text-center"
						key={product.product.id}
						value={JSON.stringify(product)}
					>
						{product.product.name}
					</option>
				))}
			</select>
			{selectedProduct && (
				<>
					<input
						className="text-center col-2"
						type="number"
						id="product-quantity"
						value={quantity}
						onChange={handleQuantityChange}
					/>

					<button
						type="button"
						className="border btn btn-light"
						onClick={handleIncreaseClick}
					>
						+
					</button>
					<button
						type="button"
						className="border btn btn-light"
						onClick={handleDecreaseClick}
					>
						-
					</button>
					<button className="btn btn-dark" onClick={() => handleConfirm()}>
						Confirmar
					</button>
				</>
			)}
		</form>
	);
};

export default SelectProducts;
