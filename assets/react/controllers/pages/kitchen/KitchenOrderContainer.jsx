import React from 'react';
import KitchenOrderCard from './KitchenOrderCard';

function KitchenOrderContainer({ user, useStateOrder }) {
	const { orders } = useStateOrder;
	const renderOrders = orders?.map((order) => (
		<KitchenOrderCard
			key={order.id}
			order={order}
			user={user}
			useStateOrder={useStateOrder}
		/>
	));

	return (
		<section className="flex-wrap container-fluid d-flex justify-content-center">
			{renderOrders}
		</section>
	);
}

export default KitchenOrderContainer;
