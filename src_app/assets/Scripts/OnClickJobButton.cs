using UnityEngine;
using System.Collections;
using UnityEngine.EventSystems;

public class OnClickJobButton : MonoBehaviour, IPointerClickHandler{
    
    [HideInInspector]
    public int identifier;

    JobPanel jobPanel;

    void Awake()
    {
        jobPanel = FindObjectOfType<JobPanel>();
    }

    public void OnPointerClick(PointerEventData eventData)
    {
        jobPanel.Enter(identifier);
	}
}
