using UnityEngine;
using System.Collections;
using UnityEngine.UI;

public class JobPanel : MonoBehaviour {
    
    public GameObject mainTitle, panelTitle;
    public Text descriptionText;
    public Text[] scheduleTexts;
    public Text otherInfoText;
    public Animator animCoverPanel;

    bool checkDouble = true;
    int _identifier;

	public void Enter (int _i)
    {
        _identifier = _i;
        mainTitle.SetActive(false);
        panelTitle.SetActive(true);
        panelTitle.GetComponentInChildren<Text>().text = ListCreator.jobOffers[_identifier].title;

        descriptionText.text = ListCreator.jobOffers[_identifier].description;

        for (int i = 0; i < 7; i++)
        {
            string formatted;

            if (ListCreator.jobOffers[_identifier].schedule.Length > 1)
            {
                formatted = ListCreator.jobOffers[_identifier].schedule[i];
                if (formatted == "")
                    formatted = "<color=grey>/</color>";
                else
                {
                    formatted = formatted.Remove(2, 2);
                    formatted = formatted.Remove(5, 2);
                }
            }
            else
                formatted = "<color=grey>/</color>";

            scheduleTexts[i].text = formatted;
        }

        string limitations = "", salary = "", employer = "", name = "", street = "", zipCode = "", phone = "";

        foreach (var str in ListCreator.jobOffers[_identifier].limitations)
            limitations += "#<b>" + str + "</b>, ";
        limitations = limitations.Substring(0, limitations.Length - 2);

        var money = ListCreator.jobOffers[_identifier].pay.ToString();
        if (money == "0")
            salary = "Flexible";
        else
            salary =  money + " S$ / hour";

        var company = ListCreator.jobOffers[_identifier].company.Split('/');
        employer = company[1];
        name = company[0];

        var address = ListCreator.jobOffers[_identifier].address.Split('/');
        street = address[0];
        zipCode = address[1];

        phone = "+65 " + ListCreator.jobOffers[_identifier].phone;

        otherInfoText.text = "<i>Health requirements:</i> " + limitations + "\n\n<i>Salary:</i> " + salary + "\n\n<i>Type of employer:</i> " + employer + "\n\n<i>Name:</i> " + name + "\n\n<i>Address:</i> " + street + ", " + zipCode + "\n\n\n<i>Telephone:</i> " + phone + "\n";

        animCoverPanel.SetTrigger("FadeIn");
	}

    public void CallPhone()
    {
        string strPhone = "tel:" + ListCreator.jobOffers[_identifier].phone;
        Application.OpenURL(strPhone);
    }

    public void Exit ()
    {
        mainTitle.SetActive(true);
        panelTitle.SetActive(false);
        animCoverPanel.SetTrigger("FadeOut");
    }

    IEnumerator CheckExit()
    {
        if (panelTitle.activeInHierarchy)
        {
            Exit();
            yield return new WaitForSeconds(0.5f);
            checkDouble = true;
        }
        else
            Application.Quit();
    }

    void Update()
    {
        if (Input.GetKey("escape") && checkDouble)
        {
            checkDouble = false;
            StartCoroutine(CheckExit());
        }
    }
}
