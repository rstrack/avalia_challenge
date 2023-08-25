export const formatDateString = (date: string): string => {
  const _date = new Date(date);
  const day = _date.getDate();
  const month = _date.getMonth();
  const year = _date.getFullYear();

  return day + '/' + month + '/' + year;
};
